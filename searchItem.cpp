//Function to search for an item
void searchItem(const vector<Item>& items)
{
   string query;
    cout << "Enter item name: ";
    getline(cin, query);

    bool found = false;

    for (const auto& item : items) 
    {
        if (item.name.find(query) != string::npos) //half match
        { 
            cout << "Found: " << item.name << ", Item Number: " << item.itemNum << endl;
            found = true;
        }
    }

    if (!found) 
    {
        cout << "No matching item found." << endl;
    }
}
