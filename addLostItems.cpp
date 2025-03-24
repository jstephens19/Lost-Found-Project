//Function adds lost items to the lost_item table
void addLostItems(int user_id, const string& item_name, const string& description, const string& lost_date, const string& location)
{
  try
  {
    //Pointers to objects used to establish connection,execute queries, and execute SQL queries
    sql::mysql::MySQL_Driver* driver;
    sql::Connection* con;
    sql::PreparedStatement* pstmt;

    //Create connection to database
    driver = sql::mysql::get_mysql_driver_instance();

    //Establish connection
    con = driver->connect("tcp://127.0.0.1:3306", "root", "root");
    //Specifies our database
    con = setSchema->("lost_found");
    // Insert Statement
    pstmt = con->prepareStatement("INSERT INTO lost_items (user_id, item_name, description, lost_date, location) VALUES (?, ?, ?, ?, ?)");
    //FINISH FUNCTION

  }
}
