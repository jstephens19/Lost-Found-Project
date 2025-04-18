#include <mysql_driver.h>
#include <mysql_connection.h>
#include <cppconn/prepared_statement.h>
#include <cppconn/resultset.h>
#include <iostream>
#include <string>

using namespace std;

// Function to add lost items to the database
void addLostItems(int user_id, const string& item_name, const string& description, const string& lost_date, const string& location)
{
    try 
    {
        sql::mysql::MySQL_Driver* driver;
        sql::Connection* con;
        sql::PreparedStatement* pstmt;

        driver = sql::mysql::get_mysql_driver_instance();
        con = driver->connect("tcp://127.0.0.1:3306", "root", "Sp0ngebob41913!?");
        con->setSchema("lost_found");

        pstmt = con->prepareStatement("INSERT INTO lost_items (user_id, item_name, description, lost_date, location) VALUES (?, ?, ?, ?, ?)");

        pstmt->setInt(1, user_id);
        pstmt->setString(2, item_name);
        pstmt->setString(3, description);
        pstmt->setString(4, lost_date);
        pstmt->setString(5, location);

        pstmt->execute();
        cout << "Lost item added successfully." << endl;

        delete pstmt;
        delete con;
    } 
    catch (sql::SQLException& e) 
    {
        cerr << "SQL error in addLostItems(): " << e.what() << endl;
    }
}

int main() {
    // Real user inputs
    string name, email, item_name, description, lost_date, location;

    // Get user input
    cout << "Enter your name: ";
    getline(cin, name);

    cout << "Enter your email: ";
    getline(cin, email);

    cout << "Enter the item name: ";
    getline(cin, item_name);

    cout << "Enter a description of the item: ";
    getline(cin, description);

    cout << "Enter the lost date (YYYY-MM-DD): ";
    getline(cin, lost_date);

    cout << "Enter the location where you lost the item: ";
    getline(cin, location);

    try {
        sql::mysql::MySQL_Driver* driver = sql::mysql::get_mysql_driver_instance();
        unique_ptr<sql::Connection> con(driver->connect("tcp://127.0.0.1:3306", "root", "Sp0ngebob41913!?"));
        con->setSchema("lost_found");

        // Check if user exists
        unique_ptr<sql::PreparedStatement> checkUser(con->prepareStatement("SELECT user_id FROM users WHERE email = ?"));
        checkUser->setString(1, email);
        unique_ptr<sql::ResultSet> res(checkUser->executeQuery());

        int user_id;
        if (res->next()) {
            user_id = res->getInt("user_id");
        } else {
            // Insert new user
            unique_ptr<sql::PreparedStatement> insertUser(con->prepareStatement("INSERT INTO users (name, email) VALUES (?, ?)"));
            insertUser->setString(1, name);
            insertUser->setString(2, email);
            insertUser->execute();

            // Get new user ID
            unique_ptr<sql::PreparedStatement> getId(con->prepareStatement("SELECT LAST_INSERT_ID() AS user_id"));
            res.reset(getId->executeQuery());
            res->next();
            user_id = res->getInt("user_id");
        }

        // Call your function to add lost item
        addLostItems(user_id, item_name, description, lost_date, location);
    } 
    catch (sql::SQLException& e) {
        cerr << "SQL error in main(): " << e.what() << endl;
        return 1;
    }

    return 0;
}
