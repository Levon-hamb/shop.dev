<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		$cate = array("Antiques", "Art", "Baby", "Books", "Business & Industrial", "Cameras & Photo", "Cell Phones & Accessories",
            "Clothing, Shoes & Accessories", "Coins & Paper Money", "Collectibles", "Computers/Tablets & Networking", "Consumer Electronics",
            "Crafts", "Dolls & Bears", "DVDs & Movies", "Entertainment Memorabilia", "Gift Cards & Coupons", "Health & Beauty", "Home & Garden",
            "Jewelry & Watches", "Music", "Musical Instruments & Gear", "Pet Supplies", "Pottery & Glass", "Real Estate", "Specialty Services",
            "Sporting Goods", "Sports Mem, Cards & Fan Shop", "Stamps", "Tickets & Experiences", "Toys & Hobbies", "Travel", "Video Games & Consoles", "Everything Else");

		foreach($cate as $ca){
			Categorie::create(array('category_name'=> $ca));
		}
	}

}
