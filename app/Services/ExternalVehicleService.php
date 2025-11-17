<?php

namespace App\Services;

use Illuminate\Database\Connection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExternalVehicleService
{
    private ?Connection $connection = null;

    private function getConnection(): Connection
    {
        if ($this->connection === null) {
            $this->connection = DB::connection('external_mysql');
        }

        return $this->connection;
    }

    private function buildWhereClause(string $searchType, string $searchQuery): array
    {
        $allowed = [
            'vehicle_id' => 'vehicle.vehicle_id',
            'veh_chassis_number' => 'vehicle.veh_chassis_number',
        ];

        $key = strtolower($searchType);
        if (! array_key_exists($key, $allowed)) {
            $key = 'veh_chassis_number';
        }

        $column = $allowed[$key];

        return ["{$column} = ?", [$searchQuery]];
    }

    public function getVehicleDetails(string $searchType, string $searchQuery): array
    {
        [$where, $bindings] = $this->buildWhereClause($searchType, $searchQuery);

        $sql = "SELECT vehicle.vehicle_id as vehicle_id,
                make.make_name as make,
                model.model_name as model,
                vehicle.veh_chassis_model as chassis_model,
                vehicle.veh_chassis_number as chassis_number,
                vehicle.veh_cc,
                vehicle.veh_year,
                vehicle.veh_color,
                vehicle.veh_buy_date,
                vehicle.veh_auc_ship_number,
                vehicle.veh_net_weight,
                vehicle.veh_m3,
                vehicle.veh_l,
                vehicle.veh_h,
                vehicle.veh_w,
                vehicle.veh_n1,
                vehicle.veh_n2,
                vehicle.veh_n3,
                vehicle.veh_n4,
                vehicle.veh_buy_price,
                vehicle.yard_date_in,
                rikso.rikso_from_place_id,
                rikso.rikso_to_place_id,
                rikso.rikso_cost,
                rikso_company.rikso_company_name as rikso_company
            FROM tbl_vehicle AS vehicle
                LEFT JOIN tbl_vehicle_make AS make ON make.make_id = vehicle.make_id
                LEFT JOIN tbl_vehicle_model AS model ON model.model_id = vehicle.model_id
                LEFT JOIN tbl_vehicle_purchase AS purchase ON purchase.vehicle_id = vehicle.vehicle_id
                LEFT JOIN tbl_rikso_details AS rikso ON rikso.vehicle_id = vehicle.vehicle_id
                LEFT JOIN tbl_rikso_company AS rikso_company ON rikso_company.rikso_company_id = rikso.rikso_company_id
            WHERE {$where}";

        try {
            $connection = $this->getConnection();
            $rows = $connection->select($sql, $bindings);

            $vehicles = array_map(fn ($r) => (array) $r, $rows);

            foreach ($vehicles as &$vehicle) {
                $vehicleId = $vehicle['vehicle_id'] ?? null;
                if ($vehicleId) {
                    $images = $connection->select('SELECT veh_image FROM tbl_vehicle_images WHERE vehicle_id = ?', [$vehicleId]);
                    $vehicle['images'] = array_map(fn ($img) => 'https://senda.us/autocraft/avisnew/images/veh_images/'.$img->veh_image, $images);
                } else {
                    $vehicle['images'] = [];
                }
            }

            return [
                'query' => $sql,
                'vehicles' => $vehicles,
            ];

        } catch (QueryException $e) {
            Log::error('ExternalVehicleService query failed', [
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    public function storeVehicleImages(int $vehicleId, array $imagePaths, int $createdBy = 0): array
    {
        $connection = $this->getConnection();
        $now = now();
        $insertedImages = [];
        $queries = [];

        try {
            foreach ($imagePaths as $index => $imagePath) {
                // Extract filename from path (get last part after /)
                $fileName = basename($imagePath);

                // Truncate to 100 characters if needed (varchar(100) limit)
                if (strlen($fileName) > 100) {
                    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                    $nameWithoutExt = pathinfo($fileName, PATHINFO_FILENAME);
                    $fileName = substr($nameWithoutExt, 0, 100 - strlen($extension) - 1).'.'.$extension;
                }

                $data = [
                    'vehicle_id' => $vehicleId,
                    'veh_image' => $fileName,
                    'ordering' => 99,
                    'web_show' => 1,
                    'email_by' => null,
                    'created_by' => $createdBy,
                    'created_on' => $now->format('Y-m-d H:i:s'),
                    'updated_by' => $createdBy,
                    'updated_on' => $now->format('Y-m-d H:i:s'),
                    'aleado_images' => null,
                ];

                // Build the SQL query for debugging
                $columns = implode(', ', array_keys($data));
                $placeholders = implode(', ', array_fill(0, count($data), '?'));
                $sql = "INSERT INTO tbl_vehicle_images ({$columns}) VALUES ({$placeholders})";
                $bindings = array_values($data);

                // Build full query with bindings for debugging
                $fullQuery = $sql;
                foreach ($bindings as $binding) {
                    $value = is_null($binding) ? 'NULL' : (is_string($binding) ? "'".addslashes($binding)."'" : $binding);
                    $fullQuery = preg_replace('/\?/', $value, $fullQuery, 1);
                }

                $queries[] = [
                    'sql' => $sql,
                    'bindings' => $bindings,
                    'full_query' => $fullQuery,
                    'data' => $data,
                ];

                $imageId = $connection->table('tbl_vehicle_images')->insertGetId($data);

                $insertedImages[] = [
                    'image_id' => $imageId,
                    'vehicle_id' => $vehicleId,
                    'veh_image' => $fileName,
                    'ordering' => 0,
                ];
            }

            return [
                'inserted' => $insertedImages,
                'queries' => $queries,
            ];
        } catch (QueryException $e) {
            Log::error('ExternalVehicleService storeVehicleImages failed', [
                'vehicle_id' => $vehicleId,
                'message' => $e->getMessage(),
                'sql' => $e->getSql() ?? null,
                'bindings' => $e->getBindings() ?? [],
            ]);

            throw new \RuntimeException('Failed to store vehicle images: '.$e->getMessage(), 0, $e);
        }
    }
}
