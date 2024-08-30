<?php

namespace App\Faker;

use Faker\Provider\Base;

class LeboncoinProvider extends Base
{
  protected static $typesBiensImmobiliers = [
    // Résidentiels
    'Maison individuelle',
    'Appartement',
    'Villa',
    'Studio',
    'Loft',
    'Maison de ville',
    'Maison de campagne',
    'Chalet',
    'Manoir',
    'Penthouse',
    'Maison jumelée',

    // Commerciaux
    'Bureaux',
    'Locaux commerciaux',
    'Centre commercial',
    'Entrepôt',
    'Atelier',
    'Hôtel',
    'Café / Restaurant',
    'Immeuble de bureaux',

    // Industriels
    'Usine',
    'Site de production',
    'Zone logistique',
    'Parc industriel',

    // Agricoles
    'Ferme',
    'Terrain agricole',
    'Exploitation viticole',
    'Prairie',

    // Terrains
    'Terrain constructible',
    'Terrain non constructible',
    'Terrain agricole',
    'Terrain forestier',

    // Autres
    'Parking/Garage',
    'Hangar',
    'Marina',
    'Dépendance'
  ];

  /**
   * Retourne une chaîne de caractère avec le type de bien, le nombre de pièces, et la surface du bien
   * @return string
   */
  public function getSubject()
  {
    return sprintf(
      '%s %d pièces %d m²',
      $this->generator->randomElement(static::$typesBiensImmobiliers),
      $this->generator->numberBetween(1, 5),
      $this->generator->numberBetween(30, 150)
    );
  }

  /**
   * Renvoie les données principale d'un bien 
   * @param $numberOfImages int
   * @return array
   */
  public function getPrincipalData($numberOfImagePerSize)
  {
    $number = intval($numberOfImagePerSize);
    $price_cents = $this->generator->numerify('######00');
    $data = [
      'list_id' => $this->generator->numerify('##########'),
      'first_publication_date' => $this->generator->dateTimeThisDecade->format('Y-m-d H:i:s'),
      'index_date' => $this->generator->dateTimeThisYear->format('Y-m-d H:i:s'),
      'status' => $this->generator->randomElement(['active', 'inactive']),
      'category_id' => $this->generator->randomNumber(1, true),
      'category_name' => 'Ventes immobilières',
      'subject' => $this->getSubject(),
      'body' => sprintf(
        '%s\n\n%s vous propose : Idéal Primo-accédants, ou investisseurs..!!!\n\nMaison de ville située sur la commune de %s,\nCette maison de Type %d d\'une surface habitable de %d m², se compose d\'une cuisine équipée avec cellier, d\'une pièce de vie, d\'une première chambre avec salle d\'eau et WC, d\'une seconde chambre avec une partie bureau ou dressing.\n\nLes plus de ce bien :\nLes menuiseries sont récentes, en PVC double vitrage,\nLe système de chauffage s\'effectue par le biais d\'une pompe à chaleur.\n\nNe manquez pas cette opportunité, contactez-nous afin d\'organiser une visite.\n\nHonoraires d’agence à la charge du vendeur.',
        $this->getSubject(),
        $this->generator->company,
        $this->generator->city,
        $this->generator->numberBetween(1, 5),
        $this->generator->numberBetween(30, 150)
      ),
      'brand' => 'leboncoin',
      'ad_type' => $this->generator->randomElement(['offer', 'demand']),
      'url' => $this->generator->url,
      'price' => [$price_cents / 100],
      'price_cents' => $price_cents,
      'images' => [
        'thumb_url' => $this->generator->imageUrl(200, 200),
        'small_url' => $this->generator->imageUrl(400, 300),
        'nb_images' => intval($number * 3),
        'urls' => array_map(function () {
          return $this->generator->imageUrl(800, 600);
        }, range(1, $number)),
        'urls_thumb' => array_map(function () {
          return $this->generator->imageUrl(200, 200);
        }, range(1, $number)),
        'urls_large' => array_map(function () {
          return $this->generator->imageUrl(1200, 800);
        }, range(1, $number))
      ]
    ];

    return $data;
  }


  /**
   * Renvoie les données plus approfondie du bien
   * @return array
   */
  public function getRealEstateData()
  {
    $data = [];

    // Données prioritaires
    $data['Type de bien'] = $this->generator->randomElement(static::$typesBiensImmobiliers);
    $data['Surface habitable'] = $this->generator->numberBetween(20, 300) . ' m²';
    $data['Nombre de pièces'] = $this->generator->numberBetween(1, 10);
    $data['Classe énergie'] = $this->generator->randomElement(['A', 'B', 'C', 'D', 'E', 'F', 'G']);
    $data['GES'] = $this->generator->randomElement(['A', 'B', 'C', 'D', 'E', 'F', 'G']);
    $data['Ascenseur'] = $this->generator->boolean ? 'Oui' : 'Non';
    $data['Honoraires inclus'] = $this->generator->boolean ? 'Oui' : 'Non';
    $data['Nombre d’étages dans l’immeuble'] = $this->generator->numberBetween(1, 5);
    $data['Nombre de chambres'] = $this->generator->numberBetween(1, 5);
    $data['Référence'] = $this->generator->uuid;

    // Données non prioritaires
    $data['SIREN'] = $this->generator->siren();
    $data['Prix par m²'] = $this->generator->numberBetween(1000, 5000) . ' €';
    $data['Mandat Type'] = $this->generator->randomElement(['simple', 'exclusif']);
    $data['Type de vente'] = $this->generator->randomElement(['old', 'new']);
    $data['Référence de l\'annonce'] = $this->generator->uuid;
    $data['Lien bareme'] = 'https://bareme.example.com/detail/' . $this->generator->randomNumber(5, true);
    $data['Nom du store'] = $this->generator->company;

    return $data;
  }

  /**
   * Renvoie les informations du propriétaire du bien
   * @return array
   */
  public function getOwnerInformation()
  {
    return array(
      "store_id" => static::numberBetween(10000000, 99999999),
      "user_id" => $this->generator->uuid(),
      "type" => static::randomElement(['pro', 'private']),
      "name" => $this->generator->firstname() . ' ' . $this->generator->lastname(),
      "siren" => $this->generator->siren(),
      "pro_rates_link" => $this->generator->url(),
      "no_salesmen" => $this->generator->boolean(),
      "activity_sector" => $this->generator->randomDigit()
    );
  }

  /**
   * Renvoie les options de l'annonce
   * @return array
   */
  public function getOptions()
  {
    return array(
      "has_option" => $this->generator->boolean(),
      "booster" => $this->generator->boolean(),
      "photosup" => $this->generator->boolean(),
      "urgent" => $this->generator->boolean(),
      "gallery" => $this->generator->boolean(),
      "sub_toplist" => $this->generator->boolean(),
      "continuous_top_ads" => $this->generator->boolean(),
      "highlight" => $this->generator->boolean()
    );
  }

  /**
   * Renvoie des données de localisation du bien
   * @return array
   */
  public function getLocation()
  {
    $city = $this->generator->city();
    $zipcode = $this->generator->postcode();
    return array(
      "country_id" => 'FR',
      "region_id" => $this->generator->numberBetween(1, 17),
      "region_name" => $this->generator->region(),
      "department_id" => $this->generator->departmentNumber(),
      "department_name" => $this->generator->departmentName(),
      "city_label" => $city . ' (' . $zipcode . ')',
      "city" => $city,
      "zipcode" => $zipcode,
      "lat" => $this->generator->latitude(),
      "lng" => $this->generator->longitude(),
      "source" => "city",
      "provider" => "here",
      "is_shape" => $this->generator->boolean(),
      "feature" => array(
        "type" => "Feature",
        "geometry" => array(
          "type" => "Point",
          "coordinates" => [
            $this->generator->latitude(),
            $this->generator->longitude()
          ]
        ),
        "properties" => null
      )
    );
  }

  /**
   * Renvoie toutes les informations permettant de faire un annonce
   * @return array
   */
  public function getProperty($data)
  {
    $other = array(
      "has_phone" => $this->generator->boolean(),
      "is_boosted" => $this->generator->boolean(),
      "similar" => null
    );
    return array_merge(
      $this->getPrincipalData($data),
      $this->getRealEstateData(),
      $this->getLocation(),
      $this->getOwnerInformation(),
      $this->getOptions(),
      $other
    );
  }
}
