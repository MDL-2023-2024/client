<?php

namespace App\Service;

/**
 * Service permettant de communiquer avec l'API FFE.
 */
class ApiService {

    /**
     * @var string L'URL de l'API.
     */
    private $url;
    
    public function __construct()
    {
        $this->url = "http://".$_SERVER['SERVER_NAME']."/api";;
    }

    /**
     * Récupère la liste des licenciés.
     *
     * @return array<string, mixed> La liste des licenciés.
     */
    public function getLicencies()
    {
        $response = file_get_contents($this->url . '/licencies');
        return json_decode($response, true);
    }

    /**
     * Récupère un licencié par son identifiant.
     *
     * @param int $id L'identifiant du licencié.
     * @return array<string, mixed> Le licencié.
     */
    public function getLicencie($id)
    {
        $response = file_get_contents($this->url . '/licencies?page=1&numLicence=' . $id);
        return json_decode($response, true);
    }

    /**
     * Récupère un licencié par son mail ou son numéro de licence.
     *
     * @param string $data Le mail ou le numéro de licence du licencié.
     * @return array<string, mixed>|null Le licencié ou null si non trouvé.
     */
    public function getLicencieBy($data): array|null
    {
        $licencies = $this->getLicencies()['hydra:member'];
        for ($i = 0; $i < count($licencies); $i++) {
            if ($licencies[$i]['mail'] == $data or $licencies[$i]['numLicence'] == $data) {
                return $licencies[$i];
            }
        }
        return null;
    }

    /**
     * Récupère le nom d'un licencié par son identifiant.
     *
     * @param int $id L'identifiant du licencié.
     * @return string Le nom du licencié.
     */
    public function getNomById($id): string
    {
        $licencie = $this->getLicencie($id);
        return $licencie['hydra:member'][0]['nom'];
    }

    /**
     * Récupère le prénom d'un licencié par son identifiant.
     *
     * @param int $id L'identifiant du licencié.
     * @return string Le prénom du licencié.
     */
    public function getPrenomById($id): string
    {
        $licencie = $this->getLicencie($id);
        return $licencie['hydra:member'][0]['prenom'];
    }
}