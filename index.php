<?php

class database
{

    public $conn;

    function __construct($host, $username, $password, $database)
    {
        $this->conn = new mysqli($host, $username, $password, $database);

    }
    function create($table, $array)
    {
        $array_keys = implode(' , ', array_keys($array));

        $array_values = implode(" ',' ", array_values($array));

        $sql = "INSERT INTO $table ($array_keys) VALUES ('$array_values')";

        if ($this->conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    function read($table, $id = false)
    {
        $sql = "SELECT * FROM $table";
        if ($id) {
            $sql .= " WHERE id = $id";
        }
        $result = $this->conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);

    }
    function update($table, $params, $id)
    {
        $newArr = [];
        foreach ($params as $key => $value) {
            $newArr[] = "$key = '$value'";
        }

        $params_string = implode(', ', $newArr);

        $sql = "UPDATE $table SET $params_string WHERE id = $id";

        $this->conn->query($sql);

        if ($this->conn->query($sql)) {
            return 'Data updated Successfuly Affected Row: ' . $this->conn->affected_rows;
        } else {
            return false;
        }
    }
    function delete($table, $id)
    {
        $sql = "DELETE FROM $table WHERE id = $id";

        if ($this->conn->query($sql)) {
            return 'Data deleted Successfuly Affected Row: ' . $this->conn->affected_rows;
        } else {
            return false;
        }
    }
    function __destruct()
    {
        $this->conn->close();
    }
}

//crud for employee data in a table named "users"

$employee = new database('localhost', 'root', '', 'oop_crud');

$employee->create('users', [ 'name' => 'Rida', 'email' => 'rida@email.com', 'password' => 'rida' ]);

print_r($employee->read('users', 50));

$employee->update('users', [ 'name' => 'Ahmed', 'email' => 'emal@mail.com' ], 51);

$employee->delete('users', 53);


//crud for manager data in a table named "admins"

$manager = new database('localhost', 'root', '', 'oop_crud');

$manager->create('admins', [ 'rank' => 'general manager', 'salary' => '100000', 'experience' => '10 years' ]);

print_r($manager->read('admins'));

$manager->update('admins', [ 'rank' => 'manager', 'salary' => '50,000' ], 2);

$manager->delete('admins', 1);

?>