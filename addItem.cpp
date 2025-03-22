//Function to add item to list
void addItem(vector<Item>& items) 
{
  string itemName;
  int itemNum;

  
  cout << "Enter item name: ";
  getline(cin, itemName);
  cout << "Enter item number: ";
  cin >> itemNum;
  cin.ignore(); 

  //Add item to list
  items.push_back(Item(itemName, itemNum));
  cout << "Item added!" << endl;
}
