<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductCategorySeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            "Home, Kitchen & Tools" => [
                "Furniture" => [
                    "Bedroom Furniture",
                    "Living Room Furniture",
                    "Kitchen & Dining Room Furniture",
                    "Accent Furniture",
                    "Kids' Furniture",
                    "Home Office Furniture",
                    "Bathroom Furniture",
                    "Home Entertainment Furniture",
                    "Other Furniture & Replacement Parts"
                ],
                "Decor" => [
                    "Home Decor",
                    "Wall Art",
                    "Seasonal Decor"
                ],
                "Kitchen & Dining" => [
                    "Food & Beverage",
                    "Kitchen Storage & Organization",
                    "Dining & Entertaining",
                    "Kitchen Utensils & Gadgets",
                    "Cookware",
                    "Coffee, Tea & Espresso",
                    "Bakeware",
                    "Kitchen & Table Linens",
                    "Other Kitchen & Dining Supplies"
                ],
                "Bedding" => [
                    "Blankets & Throws",
                    "Quilts & Sets",
                    "Bedding Sets & Collections",
                    "Bedding Accessories",
                    "Bed Pillows & Pillowcases"
                ],
                "Home Improvement" => [
                    "Home Storage & Organization",
                    "Heating, Cooling & Air Quality",
                    "Lighting & Ceiling Fans",
                    "Building Supplies",
                    "Electrical",
                    "Other Home Improvement Supplies"
                ],
                "Lawn & Garden" => [
                    "Patio Supplies",
                    "Pools, Hot Tubs & Supplies",
                    "Other Patio, Lawn & Garden Supplies"
                ],
                "Bathroom" => [
                    "Bathroom Fittings & Accessories",
                    "Bath Towels",
                    "Bath Rugs"
                ],
                "Appliances" => [
                    "Kitchen Appliances",
                    "Household Appliance",
                    "Appliance Parts & Accessories",
                    "Other Appliances"
                ],
                "Power & Hand Tools" => [
                    "Power Tools, Parts & Accessories",
                    "Hand Tools",
                    "Tool Organizers",
                    "Gardening Tools"
                ],
                "Event & Party Supplies" => [
                    "Event & Party Supplies"
                ],
                "Lamps & Light Fixtures" => [
                    "Lamps & Light Fixtures"
                ],
                "Hardware" => [
                    "Hardware"
                ],
                "Kitchen & Bath Fixtures" => [
                    "Kitchen & Bath Fixtures"
                ],
                "Fine Art" => [
                    "Fine Art"
                ],
                "Gifts" => [
                    "Gifts"
                ]
            ],
            "Personal Care & Health" => [
                "All Beauty" => [
                    "Fragrance",
                    "Makeup",
                    "Skin Care",
                    "Hair Care",
                    "Beauty Tools & Accessories",
                    "Oral Care"
                ],
                "Health, Household & Baby Care" => [
                    "Sexual Wellness",
                    "Health Care",
                    "Medical Supplies",
                    "Personal Care",
                    "Household Supplies",
                    "Wellness & Relaxation",
                    "Baby Care & Child Care"
                ],
                "Men's Grooming" => [
                    "Men's Grooming"
                ]
            ],
            "Outdoor" => [
                "Outdoor Furniture" => [
                    "Patio Furniture Sets",
                    "Patio Seating",
                    "Patio Tables",
                    "Patio Furniture Covers",
                    "Umbrellas & Shade",
                    "Hammocks, Stands & Accessories",
                    "Other Patio Furniture"
                ],
                "Camping & Hiking" => [
                    "Navigation & Electronics",
                    "Camping & Hiking Personal Care",
                    "Lights & Lanterns",
                    "Tents & Shelters",
                    "Camping Dining Items",
                    "Camping Furniture",
                    "Backpacks & Bags",
                    "Camping Cookware",
                    "Sleeping Bags & Camp Bedding",
                    "Safety & Survival",
                    "Knives & Tools",
                    "Freeze-Dried Food",
                    "Water Bottles & Containers",
                    "Other Camping & Hiking Products"
                ],
                "Gardening & Lawn Care" => [
                    "Pots, Planters & Container Accessories",
                    "Watering Equipment",
                    "Plant Support Structures",
                    "Greenhouses & Accessories",
                    "Plants, Seeds & Bulbs",
                    "Other Gardening & Lawn Care"
                ],
                "Outdoor Decor" => [
                    "Outdoor Curtains",
                    "Decoration Lighting",
                    "Yard Signs",
                    "Other Outdoor Decor"
                ],
                "Cycling & Wheel Sports" => [
                    "Cycling & Wheel Sports Accessories",
                    "Electric Bikes",
                    "Bike Trainers",
                    "Components & Parts",
                    "Other Cycles"
                ],
                "Pools, Hot Tubs & Supplies" => [
                    "Pools, Hot Tubs & Supplies"
                ],
                "RV Equipment" => [
                    "RV Equipment"
                ],
                "Grills & Outdoor Cooking" => [
                    "Grills & Outdoor Cooking"
                ],
                "Outdoor Storage" => [
                    "Outdoor Storage"
                ],
                "Playground & Park Equipment" => [
                    "Playground & Park Equipment"
                ],
                "Outdoor Recreation" => [
                    "Outdoor Recreation"
                ],
                "Scooters" => [
                    "Scooters"
                ],
                "Climbing" => [
                    "Climbing"
                ],
                "Skateboarding" => [
                    "Skateboarding"
                ],
                "Outdoor Heating & Cooling" => [
                    "Outdoor Heating & Cooling"
                ],
                "Electronics" => [
                    "Electronics"
                ],
                "Deck Tiles & Planks" => [
                    "Deck Tiles & Planks"
                ],
                "Dog Sports" => [
                    "Dog Sports"
                ]
            ],
            "Apparel, Shoes & Jewelry" => [
                "Jewelry & Watches" => [
                    "Rings",
                    "Earrings",
                    "Bracelets",
                    "Necklaces",
                    "Body Jewelry",
                    "Charms",
                    "Pendants",
                    "Brooches & Pins",
                    "Watches",
                    "Other Jewelry & Accessories"
                ],
                "Women" => [
                    "Women's Clothing",
                    "Women's Fashion Accessories",
                    "Women's Handbags & Wallets",
                    "Women's Shoes"
                ],
                "Men" => [
                    "Men's Fashion Accessories",
                    "Men's Clothing",
                    "Men's Shoes"
                ],
                "Unisex" => [
                    "Unisex Fashion Accessories",
                    "Unisex Clothing",
                    "Unisex Shoes",
                    "Work"
                ],
                "Luggage" => [
                    "Waist Packs",
                    "Travel Accessories",
                    "Other Luggage Supplies"
                ],
                "Fashion Accessories" => [
                    "Bags & Backpacks",
                    "Wallets, Card Cases & Money Organizers",
                    "Cold-weather Accessories",
                    "Other Fashion Accessories"
                ]
            ],
            "Toys, Kids & Baby" => [
                "Baby" => [
                    "Baby",
                    "Unisex Clothing & Other Products",
                    "Nursery & Nursery Décor",
                    "Girls' Clothing, Shoes & Accessories",
                    "Diapers",
                    "Baby Strollers",
                    "Baby Bedding",
                    "Baby Feeding",
                    "Car Seats & Other Safety Products",
                    "Boys' Clothing, Shoes & Accessories",
                    "Furniture",
                    "Baby Gifts",
                    "Monitor Boutique",
                    "Other Baby Products"
                ],
                "Toys & Games" => [
                    "Hobbies",
                    "Puzzles",
                    "Sports & Outdoor Play",
                    "Baby & Toddler Toys",
                    "Dolls & Accessories",
                    "Novelty & Gag Toys",
                    "Learning & Education",
                    "Arts & Crafts",
                    "Grown-Up Toys",
                    "Activities & Amusements",
                    "Puppets",
                    "Stuffed Animals & Plush Toys",
                    "Other Toys & Games Supplies"
                ]
            ],
            "Sports" => [
                "Fan Gear" => [
                    "Fan Gear"
                ],
                "Exercise & Fitness" => [
                    "Yoga",
                    "Strength Training Equipment",
                    "Cardio Training",
                    "Triathlon",
                    "Other Exercise & Fitness Equipment"
                ],
                "Team Sports" => [
                    "Fencing",
                    "Basketball",
                    "Football",
                    "Volleyball",
                    "Other Team Sports"
                ],
                "Leisure Sports & Game Room" => [
                    "Casino & Card Games",
                    "Trampolines & Accessories",
                    "Table Tennis",
                    "Darts & Equipment",
                    "Bowling",
                    "Other Games & Activities"
                ],
                "Hunting & Fishing" => [
                    "Fishing",
                    "Hunting",
                    "Archery",
                    "Other Hunting & Fishing Products"
                ],
                "Water Sports" => [
                    "Kitesurfing Equipment",
                    "Wakeboarding",
                    "Other Water Sports Equipment"
                ],
                "Ballet & Dance" => [
                    "Ballet & Dance"
                ],
                "Swimming" => [
                    "Swimming"
                ],
                "Boating" => [
                    "Boating"
                ],
                "Golf" => [
                    "Golf"
                ],
                "Sport Accessories" => [
                    "Sport Accessories"
                ],
                "Airsoft" => [
                    "Protective Gear",
                    "Guns",
                    "Other Airsoft Products"
                ],
                "Baseball" => [
                    "Baseball"
                ],
                "Motor Sports" => [
                    "Motor Sports"
                ],
                "Shooting" => [
                    "Gun Accessories",
                    "Other Shooting Products"
                ],
                "Gymnastics" => [
                    "Gymnastics"
                ],
                "Badminton" => [
                    "Badminton"
                ],
                "Boxing" => [
                    "Boxing Gym Equipment",
                    "Boxing Protective Gear",
                    "Boxing Gloves",
                    "Other Boxing Equipment"
                ],
                "Diving" => [
                    "Diving"
                ],
                "Surfing" => [
                    "Surfing"
                ],
                "Skating" => [
                    "Skating"
                ],
                "Snow Skiing" => [
                    "Snow Skiing"
                ],
                "Snowmobiling" => [
                    "Snowmobiling"
                ],
                "Softball" => [
                    "Softball"
                ],
                "Law Enforcement" => [
                    "Law Enforcement"
                ],
                "Other Sport Products" => [
                    "Other Sport Products"
                ]
            ],
            "Pets" => [
                "Pet Supplies" => [
                    "Pet Accessories",
                    "Pet Fashions",
                    "Furniture",
                    "Pet Toys",
                    "Collar, Leads, Harnesses & Training",
                    "Pet Carriers",
                    "Pet Food & Treats",
                    "Health & Nutrition",
                    "Grooming Tools & Accessories",
                    "Car & Travel",
                    "Dishes & Food Storage",
                    "Stain, Odor & Clean-up, House Train",
                    "Crates & Accessories",
                    "Doors & Gates",
                    "Exercise Pens & Kennels",
                    "Treats",
                    "Clippers, Blades & Accessories",
                    "Gifts For Pet Lovers",
                    "Flea & Tick",
                    "Other Pet Products"
                ],
                "Dogs" => [
                    "Dog Crates, Houses & Pens",
                    "Dog Food",
                    "Dog Apparel & Accessories",
                    "Dog Toys",
                    "Dog Beds & Furniture",
                    "Dog Collars, Harnesses & Leashes",
                    "Dog Doors, Gates & Ramps",
                    "Dog Training & Behavior Aids",
                    "Dog Feeding & Watering Supplies",
                    "Dog Grooming",
                    "Dog Carriers & Travel Products",
                    "Dog Health Supplies",
                    "Other Dog Products"
                ],
                "Cats" => [
                    "Cat Beds & Furniture",
                    "Cat Food",
                    "Cat Toys",
                    "Cat Cages",
                    "Cat Feeding & Watering Supplies",
                    "Other Cat Products"
                ],
                "Small Animals" => [
                    "Small Animal Houses & Habitats",
                    "Small Animal Carriers",
                    "Small Animal Feeding & Watering Supplies",
                    "Small Animal Grooming",
                    "Small Animal Collars, Harnesses & Leashes",
                    "Other Small Animal Products"
                ],
                "Birds" => [
                    "Bird Cages & Accessories",
                    "Bird Feeding & Watering Supplies",
                    "Other Bird Products"
                ],
                "Fish & Aquatic Pets" => [
                    "Aquarium Pumps & Filters",
                    "Fish & Aquatic Pet Food",
                    "Aquarium Decor",
                    "Other Fish & Aquatic Pet Products"
                ]
            ],
            "Electronics" => [
                "Gps" => [
                    "Tracking Devices",
                    "Automotive GPS Devices"
                ],
                "Batteries, Chargers & Power Supplies" => [
                    "Batteries, Chargers & Power Supplies"
                ],
                "Cell Phones & Accessories" => [
                    "Cell Phones & Accessories"
                ],
                "Camera, Photo & Video" => [
                    "Camera, Photo & Video"
                ],
                "Headphones" => [
                    "Headphone Accessories",
                    "Earbud Headphones",
                    "Wireless Headphones",
                    "Sports & Fitness Headphones",
                    "Other Headphones"
                ],
                "Home Automation & Security" => [
                    "Spy Gadgets",
                    "Security & Surveillance",
                    "Other Home Automation Supplies"
                ],
                "Wearable Technology" => [
                    "Wearable Technology"
                ],
                "Car Electronics" => [
                    "Car Electronics"
                ],
                "General Electronics" => [
                    "General Electronics"
                ],
                "Portable Audio & Video" => [
                    "Portable Audio & Video"
                ],
                "Bluetooth & Wireless Speakers" => [
                    "Bluetooth & Wireless Speakers"
                ],
                "Home Audio & Theater" => [
                    "Home Audio & Theater"
                ],
                "TV & Video" => [
                    "TV & Video"
                ],
                "Electronics Accessories" => [
                    "Electronics Accessories"
                ],
                "Ipod, Mp3 & Media Players" => [
                    "Ipod, Mp3 & Media Players"
                ],
                "Other Electronics Products" => [
                    "Other Electronics Products"
                ]
            ],
            "Office, School & Computers" => [
                "Office & School Supplies" => [
                    "Office & School Furniture",
                    "Office & School Chairs and Accessories",
                    "Paper",
                    "Desks & Desk Accessories",
                    "School Supplies",
                    "Office Basics",
                    "Art & Drafting",
                    "Clothes Racks",
                    "Clips & Clamps",
                    "Cards, Card Stock & Card Filing",
                    "Audio Visual",
                    "Files",
                    "Notebooks",
                    "Computer Furniture",
                    "Appointment Books",
                    "Binding Systems",
                    "Office & School Equipment",
                    "Labels",
                    "Binders",
                    "Tapes",
                    "Other Office & School Supplies"
                ],
                "Office Maintenance, Janitorial & Lunchroom" => [
                    "Office Maintenance, Janitorial & Lunchroom"
                ],
                "Computer & Office Accessories" => [
                    "Keyboards, Mice & Accessories",
                    "Audio & Video Accessories",
                    "Misc Accessories",
                    "Cleaning & Repair",
                    "Computer Cable Adapters",
                    "Printer Ink & Toner",
                    "Input Devices",
                    "Memory Cards & Accessories",
                    "Printer Accessories",
                    "Cables & Interconnects",
                    "Drive Enclosures",
                    "Usb/Firewire Hubs & Devices",
                    "Cable Security Devices",
                    "Other Computer & Office Accessories"
                ],
                "Printers" => [
                    "Printers"
                ],
                "Computers & Tablets" => [
                    "Tablets",
                    "Desktops",
                    "Laptops"
                ],
                "Computer Parts & Components" => [
                    "Cases & Power Supplies",
                    "Sleeves, Cases, And Bags",
                    "Fans & Cooling",
                    "Controller Cards",
                    "Other Computer Parts & Components"
                ],
                "Networking" => [
                    "Networking"
                ],
                "Drives & Storage" => [
                    "Drives & Storage"
                ],
                "Monitors" => [
                    "Monitors"
                ],
                "Other Office Supplies" => [
                    "Other Office Supplies"
                ]
            ],
            "Arts & Crafts" => [
                "Party Decorations & Supplies" => [
                    "Party Decorations & Supplies"
                ],
                "Painting, Drawing & Art Supplies" => [
                    "Painting",
                    "Art Paper",
                    "Drawing",
                    "Other Painting, Drawing & Art Supplies"
                ],
                "Sewing" => [
                    "Trim & Embellishments",
                    "Sewing Project Kits",
                    "Sewing Notions & Supplies",
                    "Other Sewing Supplies"
                ],
                "Crafting" => [
                    "Craft Supplies",
                    "Paper & Paper Crafts",
                    "Sculpture Supplies",
                    "Other Crafting Products"
                ],
                "Needlework" => [
                    "Cross-Stitch",
                    "Embroidery",
                    "Other Needlework Supplies"
                ],
                "Scrapbooking & Stamping" => [
                    "Other Scrapbooking & Stamping Supplies"
                ],
                "Beading & Jewelry Making" => [
                    "Beading & Jewelry Making"
                ],
                "Knitting & Crochet" => [
                    "Yarn",
                    "Knitting Needles",
                    "Knitting Kits",
                    "Other Knitting & Crochet Supplies"
                ],
                "Other Arts & Crafts Supplies" => [
                    "Other Arts & Crafts Supplies"
                ]
            ],
            "Automotive" => [
                "Automotive Parts & Accessories" => [
                    "Interior Accessories",
                    "Car Care",
                    "Other Automotive Parts & Accessories"
                ],
                "Car/Vehicle Electronics & GPS" => [
                    "Vehicle GPS",
                    "Vehicle Electronics Accessories",
                    "Other Vehicle Electronics"
                ],
                "Automotive Tools & Equipment" => [
                    "Garage & Shop",
                    "Body Repair Tools",
                    "Automotive Tools & Equipment Accessories",
                    "Tool Storage & Workbenches",
                    "Automotive Hand Tools",
                    "Tire Air Compressors & Inflators",
                    "Other Automotive Tools & Equipment"
                ],
                "Motorcycle & Powersports" => [
                    "Motorcycle & Powersports"
                ]
            ],
            "Entertainment" => [
                "Music & Musical Instruments" => [
                    "Music & Musical Instruments"
                ],
                "Video Games" => [
                    "Video Games"
                ],
                "Books & Video" => [
                    "Books & Video"
                ]
            ]
        ];


        foreach ($categories as $mainCategory => $subCategories) {
            $mainCategorySlug = strtolower(str_replace(' ', '-', $mainCategory));

            // Create main category
            $mainCategoryData = Category::create([
                'name' => $mainCategory,
                'slug' => $mainCategorySlug,
                'is_active' => true,
                'depth' => 0,
                'parent_id' => 0,
                'root_parent_id' => 0,
            ]);

            $mainCategoryId = $mainCategoryData->id;

            foreach ($subCategories as $subCategoryName => $childCategories) {
                $subCategorySlug = strtolower(str_replace(' ', '-', $subCategoryName));

                // Create subcategory
                $subCategoryData = Category::create([
                    'name' => $subCategoryName,
                    'slug' => $subCategorySlug,
                    'is_active' => true,
                    'depth' => 1,
                    'parent_id' => $mainCategoryId,
                    'root_parent_id' => $mainCategoryId,
                ]);

                $subCategoryId = $subCategoryData->id;

                foreach ($childCategories as $childCategory) {
                    $childCategorySlug = strtolower(str_replace(' ', '-', $childCategory));

                    // Create child category
                    Category::create([
                        'name' => $childCategory,
                        'slug' => $childCategorySlug,
                        'is_active' => true,
                        'depth' => 2,
                        'parent_id' => $subCategoryId,
                        'root_parent_id' => $mainCategoryId,
                    ]);
                }
            }
        }
    }
}
