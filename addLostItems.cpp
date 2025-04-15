//Function adds lost items to the lost_item table
void addLostItems(int user_id, const string& item_name, const string& description, const string& lost_date, const string& location)
{
    try 
      {
        //initialize MySQL driver and connection
        sql::mysql::MySQL_Driver* driver;
        sql::Connection* con;
        sql::PreparedStatement* pstmt;

        //SQL  instance
        driver = sql::mysql::get_mysql_driver_instance();
        //connect to database 
        con = driver->connect("tcp://127.0.0.1:3306", "root", "Sp0ngebob41913!?");
        // Set the schema/database name
        con->setSchema("lost_found");

        // SQL insert statement
        pstmt = con->prepareStatement("INSERT INTO lost_items (user_id, item_name, description, lost_date, location) VALUES (?, ?, ?, ?, ?)");

        //values to placeholders
        pstmt->setInt(1, user_id);
        pstmt->setString(2, item_name);
        pstmt->setString(3, description);
        pstmt->setString(4, lost_date);
        pstmt->setString(5, location);

        
        pstmt->execute();
        cout << "Lost item added successfully." << endl;

        
        delete pstmt;
        delete con;
    } catch (sql::SQLException& e) 
      {
        cerr << "SQL error: " << e.what() << endl;
      }
}

