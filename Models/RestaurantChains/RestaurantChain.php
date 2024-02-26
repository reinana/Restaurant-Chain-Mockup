<?php

namespace Models\RestaurantChains;

use Faker\Factory;
use Models\Companies\Company;
use Models\RestaurantLocations\RestaurantLocation;
use Interfaces\FileConvertible;


class RestaurantChain extends Company implements FileConvertible{
    protected int $chainId;
    protected array $restaurantLocations; // RestaurantLocation オブジェクトの配列
    protected string $cuisineType;
    protected int $totalLocations;
    protected int $foundedYear;
    protected string $parentCompany;

    public function __construct(
        int $chainId,
        array $restaurantLocations,
        string $cuisineType,
        int $totalLocations,
        int $foundedYear,
        string $parentCompany,
        string $name,
        int $foundedYearCompany,
        string $description,
        string $website,
        string $phone,
        string $industry,
        string $CEO,
        bool $isPubliclyTraded,
        string $country,
        string $founder,
        int $totalEmployees
    ) {
        parent::__construct($name, $foundedYearCompany, $description, $website, $phone, $industry, $CEO, $isPubliclyTraded, $country, $founder, $totalEmployees);

        $this->chainId = $chainId;
        $this->restaurantLocations = $restaurantLocations;
        $this->cuisineType = $cuisineType;
        $this->totalLocations = $totalLocations;
        $this->foundedYear = $foundedYear;
        $this->parentCompany = $parentCompany;
    }

    public function toString(): string {
        // Implement a string representation of the RestaurantChain
        return "RestaurantChain: {$this->name}, Cuisine: {$this->cuisineType}, Total Locations: {$this->totalLocations}";
    }

    public function toHTML(): string {
        $chains = "";
        $itemCount = 0;
        foreach($this->restaurantLocations as $location) {
            $chains .= $location->toHTML();
        }
        
        $htmlString = <<<HTML
        <h1 class="text-center pt-3">Restaurant Chain {$this->name}</h1>
        <div class="card">
            <div class="card-header">Restaurant Chain Information</div>
            <div class="card-body">
                <div class="accordion p-3" id="accordionExample">
                    {$chains}
                </div>
            </div>
        </div>
        HTML;

        return $htmlString;
    }

    public function toMarkdown(): string {
        // Implement a Markdown representation of the RestaurantChain
        $markdown = "# {$this->name}\n";
        $markdown .= "* Cuisine: {$this->cuisineType}\n";
        $markdown .= "* Total Locations: {$this->totalLocations}\n";
        return $markdown;
    }

    public function toArray(): array {
        // Implement an array representation of the RestaurantChain
        return [
            'name' => $this->name,
            'cuisineType' => $this->cuisineType,
            'totalLocations' => $this->totalLocations,
            'foundedYear' => $this->foundedYear,
            'parentCompany' => $this->parentCompany,
            // Add other properties as needed
        ];
    }

    public static function generateRestaurantChain() {
        $faker = Factory::create();

        $restaurantLocations =  \Helpers\RandomGenerator::generate([\Models\RestaurantLocations\RestaurantLocation::class, 'generateRestaurantLocation'], 5, 10);
        $totalLocations = count($restaurantLocations);


    // 新しいRestaurantChainインスタンスの生成とプロパティの設定
        return new RestaurantChain(
            $faker->randomNumber(5), // chainId
            $restaurantLocations, // restaurantLocations
            $faker->word, // cuisineType
            $totalLocations, // totalLocations
            $faker->year, // foundedYear (レストランチェーンの設立年)
            $faker->company, // parentCompany
            // Companyクラスのコンストラクタ引数
            $faker->company, // name
            $faker->year, // foundedYear (会社の設立年)
            $faker->paragraph, // description
            $faker->url, // website
            $faker->phoneNumber, // phone
            $faker->word, // industry
            $faker->name, // CEO
            $faker->boolean, // isPubliclyTraded
            $faker->country, // country
            $faker->name, // founder
            $faker->numberBetween(100, 10000) // totalEmployees
        );
    }
}
