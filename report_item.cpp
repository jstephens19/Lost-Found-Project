#include <iostream>
#include <string>
#include <mysql_driver.h>
#include <mysql_connection.h>
#include <cppconn/prepared_statement.h>
#include <cppconn/resultset.h>

using namespace std;

int main() 
{
    
    cout << "Content-type: text/html\n\n";

    // get form data 
    string user_id = getenv("QUERY_STRING");  
    string item_name = getenv("ITEM_NAME");
    string description = getenv("DESCRIPTION");
    string lost_date = getenv("LOST_DATE");
    string location = getenv("LOCATION");

    // check if the values are retrieved
    if (item_name.empty() || description.empty() || lost_date.empty() || location.empty()) {
        cout << "<html><body><h3>Error: All fields must be filled out!</h3></body></html>";
        return 1;
    }

    try 
      {
        // connection to the MySQL database
        sql::mysql::MySQL_Driver *driver;
        sql::Connection *con;

        driver = sql::mysql::get_mysql_driver_instance();
        con = driver->connect("tcp://127.0.0.1:3306", "root", "root"); 
        con->setSchema("lost_found");  //database

        // INSERT SQL statement
        sql::PreparedStatement *pstmt;
        pstmt = con->prepareStatement("INSERT INTO lost_items (user_id, item_name, description, lost_date, location) VALUES (?, ?, ?, ?, ?)");

        // query parameters
        pstmt->setInt(1, stoi(user_id));  
        pstmt->setString(2, item_name);
        pstmt->setString(3, description);
        pstmt->setString(4, lost_date);
        pstmt->setString(5, location);

        // execute query
        pstmt->executeUpdate();

        // Close the statement and connection
        delete pstmt;
        delete con;

        // message to the user
        cout << "<html><body><h3>Item Reported Successfully!</h3></body></html>";
      } catch (sql::SQLException &e) 
        {
        //  return an error message
          cout << "<html><body><h3>Error: " << e.what() << "</h3></body></html>";
          return 1;
        }

    return 0;
}
