<?php

namespace Models\RestaurantLocations;

use Faker\Factory;
use Interfaces\FileConvertible;
use DateTime;

class RestaurantLocation implements FileConvertible {
    private string $name;
    private string $address;
    private string $city;
    private string $state;
    private string $zipCode;
    private array $employees;
    private bool $isOpen;
    private bool $hasDriveThru;

    public function __construct(
        string $name,
        string $address,
        string $city,
        string $state,
        string $zipCode,
        array $employees,
        bool $isOpen,
        bool $hasDriveThru
    ) {
        $this->name = $name;
        $this->address = $address;
        $this->city = $city;
        $this->state = $state;
        $this->zipCode = $zipCode;
        $this->employees = $employees;
        $this->isOpen = $isOpen;
        $this->$hasDriveThru = $hasDriveThru;
    }

    public function toString(): string {
        $status = $this->isOpen ? 'Open' : 'Closed';
        return "Name: {$this->name}, Address: {$this->address}, City: {$this->city}, State: {$this->state}, Postal Code: {$this->zipCode}, Status: {$status}";
    }
    
    public function toHTML(): string {
        $status = $this->isOpen ? 'Open' : 'Closed';
        $employeeString = "";
        foreach($this->employees as $employee) {
            $employeeString .= "<tr>" . $employee->toHTML() . "</tr>";
        }
        
        // 一意のIDを生成
        $collapseId = "collapse" . uniqid(); // これにより、各アコーディオン要素が一意のIDを持つ
    
        $htmlString = <<<HTML
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button
                    type="button"
                    class="accordion-button"
                    data-bs-toggle="collapse"
                    data-bs-target="#{$collapseId}"
                    aria-expanded="true"
                    aria-controls="{$collapseId}"
                >
                    {$this->name}
                </button>
            </h2>
            <div
                id="{$collapseId}"
                class="accordion-collapse collapse"
                data-bs-parent="#accordionExample"
            >
                <div class="accordion-body">
                    <p>Company Name: {$this->name} Address: {$this->address} Zip Code: {$this->zipCode}</p>
            <hr />
            <h5>Employees:</h5>
            <table class="table table-bordered">
                <tbody>
                    {$employeeString}
               </tbody>
            </table>
                </div>
            </div>
        </div>
    HTML;
        return $htmlString;
    }

    public function toMarkdown(): string {
        $status = $this->isOpen ? 'Open' : 'Closed';
        return "**Name**: {$this->name}\n**Address**: {$this->address}\n**City**: {$this->city}\n**State**: {$this->state}\n**Postal Code**: {$this->zipCode}\n**Status**: {$status}";
    }

    public function toArray(): array {
        return [
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'postalCode' => $this->zipCode,
            'isOpen' => $this->isOpen,
        ];
    }

    public static function generateRestaurantLocation() {
        $faker = Factory::create();
        
        // 従業員のダミーデータ生成
        $employees = \Helpers\RandomGenerator::generate([\Models\Employees\Employee::class, 'generateEmployee'], 5, 10);

        return new RestaurantLocation(
            $faker->company,
            $faker->streetAddress,
            $faker->city,
            $faker->state,
            $faker->postcode,
            $employees,
            $faker->boolean,
            $faker->boolean
        );
    }
}

