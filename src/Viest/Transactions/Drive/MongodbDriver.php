<?php

namespace Viest\Transactions\Drive;


use Illuminate\Support\Facades\DB;

class MongodbDriver implements DriverInterface
{
    private $collection = NULL;

    public function setCollection($collection)
    {
        $this->collection = $collection;
    }

    /**
     * save backup data
     *
     * @param string $collection
     * @param array  $wheres
     * @param array  $data
     * @param string $column
     * @param string $uuid
     */
    public function save($collection, array $wheres, array $data, $column, $uuid)
    {
        DB::collection($this->collection)->insert([
            'collection' => $collection,
            'wheres'     => $wheres,
            'data'       => $data,
            'uuid'       => $uuid,
            'column'     => $column,
            'rollback'   => 1
        ]);
    }

    /**
     * @param string $uuid
     *
     * @return array
     */
    public function rollback($uuid)
    {
        $backupData = DB::collection($this->collection)
            ->where('uuid', $uuid)
            ->get()
            ->toArray();

        //Retrograde
        $backupData = array_reverse($backupData);

        return $this->roolbackDB($backupData, $uuid);
    }

    /**
     * Database operation
     *
     * @param $backupData
     * @param $uuid
     * @return array
     */
    private function roolbackDB($backupData, $uuid)
    {
        foreach ($backupData as $rowData) {
            foreach ($rowData['data'] as $data) {
                foreach ($rowData['wheres'] as $where) {
                    $_id = $data['_id'];

                    // rollback
                    DB::collection($rowData['collection'])
                        ->where('_id', $_id)
                        ->update([$rowData['column'] => $data[$rowData['column']]]);

                    // check
                    $check = DB::collection($rowData['collection'])
                        ->where('_id', $_id)
                        ->where($rowData['column'], $data[$rowData['column']])
                        ->get()
                        ->toArray();

                    if (count($check) === 0) {
                        return [
                            'result' => false,
                            '_id'    => $_id,
                            'column' => $rowData['column'],
                            'expect' => $data[$rowData['column']]
                        ];
                    }
                }
            }
        }

        // update tag
        DB::collection($this->collection)
            ->where('uuid', $uuid)
            ->update(['rollback' => 2]);

        return ['result' => true];
    }
}