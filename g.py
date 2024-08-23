import mysql.connector
from collections import defaultdict, deque
import logging

# Set up logging
logging.basicConfig(level=logging.INFO, format='%(asctime)s - %(levelname)s - %(message)s')

# Step 1: Connect to the MySQL database
def connect_to_database(host, user, password, database):
    try:
        connection = mysql.connector.connect(
            host=host,
            user=user,
            password=password,
            database=database
        )
        logging.info("Successfully connected to the database.")
        return connection
    except mysql.connector.Error as err:
        logging.error(f"Error: {err}")
        return None

# Step 2: Retrieve table and foreign key information
def get_table_dependencies(cursor, database_name):
    try:
        cursor.execute(f"""
            SELECT TABLE_NAME, REFERENCED_TABLE_NAME
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE REFERENCED_TABLE_NAME IS NOT NULL
            AND TABLE_SCHEMA = '{database_name}';
        """)

        dependencies = defaultdict(list)
        for row in cursor.fetchall():
            table_name = row[0]
            referenced_table_name = row[1]
            dependencies[referenced_table_name].append(table_name)

        logging.info("Successfully retrieved table dependencies.")
        return dependencies
    except mysql.connector.Error as err:
        logging.error(f"Error: {err}")
        return None

# Step 3: Topological sorting of tables
def topological_sort(dependencies):
    try:
        indegree = defaultdict(int)
        for table in dependencies:
            for dependent_table in dependencies[table]:
                indegree[dependent_table] += 1

        queue = deque([table for table in dependencies if indegree[table] == 0])
        sorted_tables = []

        while queue:
            table = queue.popleft()
            sorted_tables.append(table)
            for dependent_table in dependencies[table]:
                indegree[dependent_table] -= 1
                if indegree[dependent_table] == 0:
                    queue.append(dependent_table)

        # Handle tables with no dependencies
        for table in dependencies:
            if table not in sorted_tables:
                sorted_tables.append(table)

        logging.info("Topological sorting completed successfully.")
        return sorted_tables
    except Exception as err:
        logging.error(f"Error during topological sorting: {err}")
        return []

# Step 4: Generate Laravel migration files
def generate_migrations(sorted_tables, cursor):
    try:
        for table in sorted_tables:
            cursor.execute(f"SHOW CREATE TABLE {table}")
            create_table_sql = cursor.fetchone()[1]
            migration_content = convert_to_laravel_migration(create_table_sql)

            migration_filename = f"{table}_migration.php"
            with open(migration_filename, "w") as migration_file:
                migration_file.write(migration_content)
            logging.info(f"Migration file created: {migration_filename}")
    except mysql.connector.Error as err:
        logging.error(f"Error fetching table creation SQL: {err}")
    except Exception as err:
        logging.error(f"Error generating migration: {err}")

def convert_to_laravel_migration(create_table_sql):
    # Convert MySQL CREATE TABLE SQL to Laravel migration syntax
    # This part needs to be customized based on your requirements
    try:
        table_name = create_table_sql.split('`')[1]
        return f"""<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

class Create{table_name.capitalize()}Table extends Migration
{{
    public function up()
    {{
        Schema::create('{table_name}', function (Blueprint $table) {{
            // Add your fields here
        }});
    }}

    public function down()
    {{
        Schema::dropIfExists('{table_name}');
    }}
}}
"""
    except Exception as err:
        logging.error(f"Error converting SQL to Laravel migration: {err}")
        return ""

if __name__ == "__main__":
    try:
        # Replace with your actual MySQL database credentials
        db_connection = connect_to_database('localhost', 'ani', 'ani1998', 'edotcom')

        if db_connection is None:
            raise Exception("Failed to connect to the database.")

        cursor = db_connection.cursor()

        dependencies = get_table_dependencies(cursor, 'edotcom')
        print(dependencies)

        if dependencies is None:
            raise Exception("Failed to retrieve table dependencies.")

        sorted_tables = topological_sort(dependencies)
        print(sorted_tables)
        if not sorted_tables:
            raise Exception("Failed to sort tables. Check for circular dependencies or missing tables.")

        # generate_migrations(sorted_tables, cursor)

    except Exception as err:
        logging.error(f"Script terminated with an error: {err}")

    finally:
        if db_connection and db_connection.is_connected():
            cursor.close()
            db_connection.close()
            logging.info("Database connection closed.")
