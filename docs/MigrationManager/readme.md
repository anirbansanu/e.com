


# `MigrationManager` Documentation

## Overview

The `MigrationManager` class facilitates the process of generating Laravel migration files from MySQL tables. It handles database connection, retrieves table dependencies, performs topological sorting to resolve migration order, and generates the appropriate migration files. It also logs the process for review and troubleshooting.

## Dependencies

- `mysql-connector-python`: For connecting to and interacting with the MySQL database.
- `collections`: Provides data structures such as `defaultdict` and `deque`.
- `logging`: For logging information and errors.
- `os`: For executing shell commands.
- `datetime`: For generating timestamps for migration filenames.

## Class Definition

### `MigrationManager`

#### Initialization

```python
def __init__(self, host, user, password, database, project_path):
```

**Parameters:**
- `host` (str): The hostname or IP address of the MySQL server.
- `user` (str): The MySQL username.
- `password` (str): The MySQL user's password.
- `database` (str): The name of the MySQL database.
- `project_path` (str): The path to the Laravel project directory where migration files will be generated.

#### Methods

##### `connect_to_database`

```python
def connect_to_database(self):
```

Establishes a connection to the MySQL database and initializes a cursor for executing queries. Logs a success message or an error if the connection fails.

##### `close_database`

```python
def close_database(self):
```

Closes the connection and cursor to the MySQL database, if they are open. Logs a success message when the connection is closed.

##### `get_table_dependencies`

```python
def get_table_dependencies(self):
```

Retrieves table dependencies from the MySQL database by querying the `INFORMATION_SCHEMA.KEY_COLUMN_USAGE` table. Returns a dictionary where the keys are table names and the values are lists of tables that depend on the key table. Also logs the dependencies or an error if retrieval fails.

##### `topological_sort`

```python
def topological_sort(self, dependencies):
```

Performs a topological sort on the table dependencies to determine the correct order for migration file generation. Handles cases of circular dependencies and logs the sorted order or an error if sorting fails.

**Parameters:**
- `dependencies` (dict): A dictionary of table dependencies.

**Returns:**
- `list`: A list of table names sorted in the order they should be migrated.

##### `generate_migrations`

```python
def generate_migrations(self, sorted_tables):
```

Generates Laravel migration files for each table in the sorted list. Uses the `php artisan migrate:generate` command and logs the success or failure of each migration generation.

**Parameters:**
- `sorted_tables` (list): A list of table names in the order they should be migrated.

##### `write_to_file`

```python
def write_to_file(self, sorted_tables, dependencies, output_log_file):
```

Writes the sorted tables and their dependencies to a log file. Logs success or failure of the file writing process.

**Parameters:**
- `sorted_tables` (list): A list of table names in the order they should be migrated.
- `dependencies` (dict): A dictionary of table dependencies.
- `output_log_file` (str): The path to the log file where the information will be written.

##### `run`

```python
def run(self):
```

Orchestrates the process by connecting to the database, retrieving table dependencies, performing topological sorting, generating migrations, and writing the results to a log file. Logs any errors that occur during the process and ensures that the database connection is closed properly.

## Usage Example

```python
if __name__ == "__main__":
    migration_manager = MigrationManager(
        host='localhost',
        user='ani',
        password='ani1998',
        database='edotcom',
        project_path='/home/ani/Documents/code_drive/Laravel_Projects/e.com'
    )
    migration_manager.run()
```

Instantiate the `MigrationManager` with the necessary database credentials and project path, and call the `run` method to start the migration generation process.

---
