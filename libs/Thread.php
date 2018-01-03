<?php

class Thread
{
    /**
     * @var mixed
     */
    private $db;

    /**
     * Thread constructor.
     *
     */
    public function __construct()
    {
        // Normally we would do things differently, but we did it this way for simplification
        require_once(__DIR__ . '/DatabaseFile.php');

        $this->db = new DatabaseFile();
    }

    /**
     * @param string $title
     * @param string $message
     * @param bool   $isVisible
     * @param int    $timePosted
     */
    public function newThread($title, $message, $isVisible, $timePosted)
    {
        $this->db->insert('thread', [
            'threadid' => $this->db->primaryKey(),
            'title' => $title,
            'message' => $message,
            'visible' => intval($isVisible),
            'timeposted' => $timePosted,
        ]);
    }

    /**
     * @param int  $numThreads
     * @param bool $includeHidden
     *
     * @return array
     */
    public function getRecentThreads($numThreads, $includeHidden)
    {
        $columns = [
            'threadid',
            'title',
            'message',
            'timeposted',
        ];

        $conditions = ($includeHidden)
            ? []
            : ['visible' => 1];

        return $this->db->select('thread', $columns, $conditions, 'timeposted', false, $numThreads);
    }
}