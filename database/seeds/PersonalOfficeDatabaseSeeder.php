<?php

use Illuminate\Database\Seeder;
use Symfony\Component\Console\Output\ConsoleOutput;
use App\Entities\NcuRemoteDB;

class PersonalOfficeDatabaseSeeder extends Seeder
{
    private $console;
    private $dataPath;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->console = new ConsoleOutput();
        $this->dataPath = 'database/data';
        
        $this->seed('basicinfo');
        $this->seed('student_info');
        $this->seed('schoolmate_info');
        $this->seed('staff_info');
    }

    /**
     * Check if the given column name exists in the instance model.
     * @param Model $instance.
     * @param string $columnName.
     * @return void.
     */
    private function checkTableExists($instance, $columnName)
    {
        $connection = $instance->getConnection();
        $tableName = $instance->getTable();
        return $connection->hasColumn($tableName, $columnName);
    }

    /**
     * Clears all records in table.
     * @param string $tableName The table to be cleared.
     * @return void.
     */
    private function clearTable($tableName)
    {
        $basicinfo = new NcuRemoteDB();
        $basicinfo->setTable($tableName);
        $basicinfo->truncate();
    }

    /**
     * Gets the data to be seeded.
     * @param string $dataLocation The location of JSON data file.
     * @return array | null Returns the data as an array. If data file
     * not found, null will be returned.
     */
    private function getData($dataLocation)
    {
        if (!File::exists($dataLocation)) {
            $this->console->writeln('File "' . $dataLocation . '" not found!');

            return null;
        }

        $jsonFile = File::get($dataLocation);

        return json_decode($jsonFile);
    }

    /**
     * Runs the specific seeding.
     * @param string $tableName The table to be seeded.
     * @return void.
     */
    private function seed($tableName)
    {
        $data = $this->getData($this->dataPath . '/' . $tableName . '.json');

        if (!empty($data)) {
            $this->clearTable($tableName);

            foreach ($data as $key => $record) {
                $instance = new NcuRemoteDB();
                $instance->setTable($tableName);
                $this->setUp($instance, $record);
                $instance->save();
            }
        }
        else {
            $this->console->writeln('Table "' . $tableName . '" will not be seeded!');
        }
    }

    /**
     * Sets up the instance and store it into database.
     * @param NcuRemoteDB $instance The new record instance.
     * @param JSON $record The data of new record instance.
     * @return void.
     */
    private function setUp($instance, $record)
    {
        foreach ($record as $columnName => $data) {
            if (!$this->checkTableExists($instance, $columnName)) {
                $this->console->writeln('Seeds into non-existing column "' . $columnName . '".');
                $this->console->writeln('Seeding aborted at "PersonalOfficeDatabaseSeeder" > "' . $instance->getTable() . '" table.');
                return;
            }

            $instance[$columnName] = $data;
        }
    }
}
