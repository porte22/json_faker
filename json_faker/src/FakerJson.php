<?php
namespace Porte22\Faker;

use Faker\Factory;
use Faker\Provider\it_IT\Address;
use Faker\Guesser\Name;
use Faker\Provider\it_IT\PhoneNumber;
use Faker\Provider\it_IT\Person;
use Faker\Provider\it_IT\Company;
use Faker\Provider\Lorem;
use Faker\Provider\Internet;
use Faker\Generator;
use Faker\Provider\Miscellaneous;
use Faker\Provider\DateTime;

require_once 'vendor/autoload.php';


class FakerJson{
    private $jsonIn=__DIR__.DIRECTORY_SEPARATOR.'..'. DIRECTORY_SEPARATOR.'json_in'.DIRECTORY_SEPARATOR;
    private $jsonOut=__DIR__.DIRECTORY_SEPARATOR.'..'. DIRECTORY_SEPARATOR.'json_out'.DIRECTORY_SEPARATOR;
  
    
    private $faker;
    
    private function getRandom($fieldName,$fieldValue){
        
        switch ($fieldName){
            case 'Province':
            case 'ProvinceOfBirth':
            case 'CityOfBirth':
                $fieldValue = substr($this->faker->city,0,2);
                break;
            case 'LastName':
                $fieldValue = $this->faker->lastName;
                break;
            case 'FirstName':
                $fieldValue = $this->faker->firstName;
                break;
            case 'Nominative':
            case 'Denomination':
                $fieldValue = $this->faker->firstName.' '.$this->faker->lastName;
                break;
            case 'CellPhone1':
            case 'PhoneNumber1':
                $fieldValue = $this->faker->phoneNumber;
                break;
            case 'EmailAddress1':
            case 'AddressLine1':
            case 'BrandDescription':
            case 'Addressee':
                $fieldValue = $this->faker->address;
                break;
            case 'TaxId':
                $fieldValue = $this->faker->taxId();
                break;
            case 'ContactId':
            case 'JobNumber':
            case 'ChassisNumber':
            case 'AniaRegistrationNumber':
            case 'ProposalNumber':
            case 'AccountNumber':
                $fieldValue = mt_rand(10000,999999);
                break;
            case 'BirthDate':
            case 'WrittenDate':
                //$fieldValue = $this->faker->dateTime();
                $fieldValue = \Faker\Provider\DateTime::dateTime()->format('Y-m-d H:i:s');
              //  $fieldValue = Faker\Provider\DateTime();
                break;
            case 'AddressNumber':
                $fieldValue = mt_rand(1,999);
                break;
            case 'City':
                $fieldValue = $this->faker->city;
                break;
            case 'Country':
                $fieldValue = Miscellaneous::countryCode();
                
                break;
            case 'PostalCode':
                $fieldValue = $this->faker->postcode;
                break;
            
        }
        
        return $fieldValue;
    }
    
    public function __construct()
    {
        
        $this->faker = new Generator();
        $this->faker->addProvider(new Person($this->faker));
        $this->faker->addProvider(new Address($this->faker));
        $this->faker->addProvider(new PhoneNumber($this->faker));
        $this->faker->addProvider(new Company($this->faker));
        $this->faker->addProvider(new Lorem($this->faker));
        $this->faker->addProvider(new Internet($this->faker));
     
    }
    
    
    private function parseArray(&$currentArray){
        foreach ($currentArray as $key=>$value){
            if (is_array($value)){
                $this->parseArray($currentArray[$key]);
            } else {
                $currentArray[$key] = $this->getRandom($key,$value);
            }
        }
 
       
        return $currentArray;
    }
    
    
    
    public function parseJson(){
        
        foreach(glob($this->jsonIn.'*') as $currentFile){
            $ay = json_decode(file_get_contents($currentFile),true);
            $randomAy =$this->parseArray($ay);
            file_put_contents($this->jsonOut.basename($currentFile), json_encode($ay));
        }
    }
    
}