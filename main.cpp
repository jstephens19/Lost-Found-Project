// Main

#include <string>
#include <iostream>
#include<vector>

class Item {        // Item class
  public:
    string name;    // Name of item
    int itemNum;    // Unique number asigned to item
  //contructor to initialize item
  Item(string itemName, int number) : name(itemName), itemNum(number){}
};

//function prototypes
void addItem(vector<Item>& items);    //add new items
void displayItems(const vector<Item>& items);    //display items
void searchItem(const vector<Item>& items);    //search items
void addLostItems(int user_id, const string& item_name, const string& description, const string& lost_date, const string& location)

int main ()
{
        vector<Item> items;
    int choice;

    while (true) 
    {
        cout << "\nLost & Found Menu:\n";
        cout << "1. Add Item\n2. Display Items\n3. Search Item\n4. Exit\n";
        
        cin >> choice;
        cin.ignore();

        switch (choice)
          {
            case 1:
                addItem(items);
                break;
            case 2:
                displayItems(items);
                break;
            case 3:
                searchItem(items);
                break;
            case 4:
                cout << "Exiting..." << endl;
                return 0;
            default:
                cout << "Invalid choice. Try again." << endl;
        }
    }
}
