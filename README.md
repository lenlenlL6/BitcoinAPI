# BitcoinAPI
A new plugin like EconomyAPI but with a different mode
# API FUNCTION
- Add Bitcoin
```
$this->bitcoin = $this->getServer()->getPluginManager()->getPlugin("BitcoinAPI");

$this->bitcoin->addBitcoin($player, "200"); //You can't use float in amount
```
- Reduce Bitcoin
```
$this->bitcoin = $this->getServer()->getPluginManager()->getPlugin("BitcoinAPI");
$this->bitcoin->reduceBitcoin($player, "200"); //Like Add Bitcoin you can't use float in amount
```
- Get All Bitcoin (Make Top Bitcoin)
```
$this->bitcoin = $this->getServer()->getPluginManager()->getPlugin("BitcoinAPI");
$this->bitcoin->getAllBitcoin(); //You can make top bitcoin with this
```
- Make New Top Bitcoin
```
$this->bitcoin = $this->getServer()->getPluginManager()->getPlugin("BitcoinAPI");
$allbitcoin = $this->bitcoin->getAllBitcoin(); //Get All Bitcoin In bitcoin.yml
arsort($allbitcoin); //Make $allbitcoin descending order
$allbitcoin = array_slice($allbitcoin, 0, 9); //Just Get 10 element in bitcoin array
$top = 1; //Count the top
foreach($allbitcoin as $name => $count){ //Loop get all name and count elements in bitcoin 
$sender->sendMessage("Top " . $top . " name is " . $name . " have " . $count . " bitcoin);
$top++;
}
