//Function to search for an item
void searchItem(const vector<Item>& items)
{
  int searchNum;
  cout << "Enter your item number: ";
  cin >> searchNum;
  cin.ignore(); //ignore \n

// go through list to find item
  for(size_t i = 0; i < item.size(); i++)
  {
     if(item[i].itemNum == searchNum)
     {
       cout << "Item Name: " << items[i].name << ", Item Number: " << items[i].itemNum << endl;
       return;
     }
  }
}
