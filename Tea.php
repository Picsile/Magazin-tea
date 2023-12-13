<?php
class Tea
{
    public function __construct(private $name, private $description, private $category, private $price, private $imageUrl, private $stock, private $offer, private $id)
    {
        $this->name = $name;
        $this->description = $description;
        $this->category = $category;
        $this->price = $price;
        $this->imageUrl = $imageUrl;
        $this->stock = $stock;
        $this->offer = $offer;
        $this->id = $id;
    }

    public function getCategory()
    {
        return $this->category;
    }
    public function getId()
    {
        return $this->id;
    }

    public function print()
    {
        echo "<b>".$this->name, "</b><br>";
        echo " <p><b>Описание: </b>".$this->description, "</p><br>";
        if (!empty($this->imageUrl)) {
            echo '<img src="' . $this->imageUrl . '" alt="" width = "448" height="300">', "<br>";
        }
        echo "Цена: ".$this->price." руб<br>";
        if ($this->offer != false) {
        echo "Скидка: ".$this->offer, "% <br>";
        }
    }
}?>
