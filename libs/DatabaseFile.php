<?php

/**
 *  This is used to simulate a database class by supporting some basic operations by saving the data locally to a file.
 */

/**
 * Class DatabaseFile
 */
class DatabaseFile
{
    /**
     * DatabaseFile constructor.
     */
    public function __construct()
    {
        $fileDirectory = $this->getFileDirectory();

        if (!is_dir($fileDirectory))
        {
            mkdir($fileDirectory);
        }
    }

    /**
     * @param string $tableName
     * @param array  $values
     */
    public function insert($tableName, array $values)
    {
        $data = $this->getData();
        $data[$tableName][] = $values;

        $this->setData($data);
    }

    /**
     * @param string $tableName
     * @param array  $columns
     * @param array  $conditions
     * @param string $orderBy
     * @param bool   $orderByAscending
     * @param int    $limit
     *
     * @return array
     */
    public function select($tableName, array $columns, array $conditions = [], $orderBy = null, $orderByAscending = true, $limit = null)
    {
        $data = $this->getData();

        if (!isset($data[$tableName]))
        {
            return [];
        }

        $filteredData = $data[$tableName];
        if ($orderBy !== null)
        {
            usort($filteredData, function($a, $b) use ($orderBy, $orderByAscending)
            {
                $aValue = $a[$orderBy];
                $bValue = $b[$orderBy];

                if ($aValue == $bValue)
                {
                    return 0;
                }

                if ($orderByAscending)
                {
                    return $aValue < $bValue ? -1 : 1;
                }
                else
                {
                    return $aValue > $bValue ? -1 : 1;
                }
            });
        }

        if (count($conditions))
        {
            $filteredData = array_filter($filteredData, function($record) use ($conditions)
            {
                foreach ($conditions as $key => $value)
                {
                    if (!isset($record[$key]))
                    {
                        throw new Exception("Invalid condition provided: {$key} = {$value}");
                    }
                    else if ($record[$key] != $value)
                    {
                        return false;
                    }
                }
                return true;
            });
        }

        if ($limit !== null && intval($limit))
        {
            $filteredData = array_slice($filteredData, 0, intval($limit));
        }

        if (count($columns))
        {
            $filteredData = array_map(function($record) use ($columns)
            {
                $returnData = [];

                foreach ($columns as $column)
                {
                    if (!isset($record[$column]))
                    {
                        throw new Exception("Invalid column provided: $column");
                    }

                    $returnData[$column] = $record[$column];
                }

                return $returnData;

            }, $filteredData);
        }

        return $filteredData;
    }

    /**
     * @return int
     */
    public function primaryKey()
    {
        return time() - strtotime('2016-11-25');
    }

    /**
     * @return array
     */
    private function getData()
    {
        if (!file_exists($this->getFileName()))
        {
            return [];
        }

        $data = unserialize(file_get_contents($this->getFileName()));

        return is_array($data) ? $data : [];
    }

    /**
     * @param array $data
     */
    private function setData(array $data)
    {
        file_put_contents($this->getFileName(), serialize($data));
    }

    /**
     * @return string
     */
    private function getFileDirectory()
    {
        return __DIR__ . '/data';
    }

    /**
     * @return string
     */
    private function getFileName()
    {
        return $this->getFileDirectory() . '/data.txt';
    }
}