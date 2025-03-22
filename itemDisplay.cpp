//Display funtion
void displayItems(const vector<Item>& items)
{
    //Check if there are any lost items
    if(items.empty())
    {
        cout<< "No items in the Lost & Found" << endl;
        return;
    }

    //display all lost & found items
    cout << "\n Lost & Found Items:" << endl;
    for(size_t i = 0; i < items.size(); i++)
    {
      cout<< "Item Name: " << items[i].name << ", Item Number: " << items[i].itemNum << endl;
    }
}
