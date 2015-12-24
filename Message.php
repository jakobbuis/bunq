<?php

/**
 * Basic model for messages table
 */
class Message
{
    /**
     * database connector
     * @var medoo
     */
    private $database;

    /**
     * Table to read
     * @var string
     */
    private $tablename = 'messages';

    /**
     * Bootstrap class
     * @param medoo $database database connector
     */
    public function __construct(medoo $database)
    {
        $this->database = $database;
    }

    /**
     * Find all messages ever, ordered by timing
     * @return array
     */
    public function getAll()
    {
        return $this->database->select($this->tablename, ['name', 'message', 'created_at']);
    }

    /**
     * Create a new message
     * @param  string $name    name of the user (VARCHAR(255))
     * @param  string $message message (TEXT)
     * @return null
     */
    public function create($name, $message)
    {
        $this->database->insert($this->tablename, [
            'name' => $name,
            'message' => $message,
            'created_at' => time()
        ]);
    }
}
