<?php

namespace App;

use Exception;
use PDO;
use stdClass;
use function array_column;

/**
 * Class MainModel
 * Trieda modelu reprezentuje dáta a logiku aplikácie.
 * @package App
 */
class MainModel extends Model
{

    /**
     * Metóda načítania zoznamu projektov z databázy
     * @param int $offset Odsadenie od začiatku
     * @param int $limit Limit položiek v dotaze
     * @param string $lang Prípona tabuľky
     * @return array|null Vracia zoznam projektov
     */
    public function readProjects($offset = -1, $limit = -1, $lang = "sk")
    {
        $lim = "";
        /*Vynútiť konverziu typu pre celočíselné parametre dotazu do databázy*/
        $offset = intval($offset);
        $limit = intval($limit);
        /*//Vynútiť konverziu typu pre celočíselné parametre dotazu do databázy*/
        /*Limity vzorkovania údajov v sql-dotazoch (na základe aktuálneho statusu stránkovania)*/
        if ($offset > -1 && $limit > 0) {
            $lim = "$offset,$limit";
        } else if ($offset === -1 && $limit > 0) {
            $lim = "$limit";
        }
        /*//Limity vzorkovania údajov v sql-dotazoch (na základe aktuálneho statusu stránkovania)*/
        $result = null;
        try {
            /*Načítanie aktuálnej "stránky" so zoznamom projektov z databázy, okrem tých, ktoré boli stiahnuté z uverejnenia*/
            $result = $this->db->query("SELECT * FROM projects_$lang WHERE published=1 ORDER BY ordering" . (!empty($lim) ? " LIMIT $lim" : "") . ";")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $err) {
        }
        return $result; // vrátiť pole projektov
    }

    /**
     * Metóda na získanie počtu riadkov v tabuľke projects_$lang
     * @param string $lang Prípona tabuľky
     * @return array|null Vracia počet riadkov v tabuľke
     */
    public function readCountProjects($lang = "sk")
    {
        $total = null;
        try {
            /*Získanie celkového počtu projektov v databáze, okrem projektov stiahnutých z uverejnenia*/
            $total = $this->db->query("SELECT COUNT(*) AS count_rows FROM projects_$lang WHERE published=1;")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $err) {
        }
        return $total; // vrátenie počtu projektov
    }

    /**
     * Metóda pridávania nových kontaktných informácií návštevníkov webovej stránky do databázy
     * @param stdClass $fields Polia formulára
     * @return bool Vracia stav vloženia reťazca do databázy
     */
    public function insertCrm($fields)
    {
        $data = array(
            ':name' => $fields->name,
            ':email' => $fields->email,
            ':request' => $fields->request
        );
        /*Pridanie novej požiadavky do tabuľky crm*/
        $stmt = $this->db->prepare('INSERT INTO crm SET name=:name, email=:email, request=:request, created_at=NOW()');
        return $stmt->execute($data);
    }

    /**
     * Metóda načítania zoznamu požiadaviek z databázy
     * @param int $offset Odsadenie od začiatku
     * @param int $limit Limit položiek v dotaze
     * @return array|null Vracia zoznam požiadaviek
     */
    public function readCrm($offset = -1, $limit = -1)
    {
        $lim = "";
        /*Vynútiť konverziu typu pre celočíselné parametre dotazu do databázy*/
        $offset = intval($offset);
        $limit = intval($limit);
        /*//Vynútiť konverziu typu pre celočíselné parametre dotazu do databázy*/
        /*Limity vzorkovania údajov v sql-dotazoch (na základe aktuálneho statusu stránkovania)*/
        if ($offset > -1 && $limit > 0) {
            $lim = "$offset,$limit";
        } else if ($offset === -1 && $limit > 0) {
            $lim = "$limit";
        }
        /*//Limity vzorkovania údajov v sql-dotazoch (na základe aktuálneho statusu stránkovania)*/
        $result = null;
        try {
            /*Získanie aktuálnej "stránky" so zoznamom žiadostí z databázy*/
            $result = $this->db->query("SELECT * FROM crm ORDER BY id" . (!empty($lim) ? " LIMIT $lim" : "") . ";")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $err) {
        }
        return $result; // vrátenie poľa používateľských požiadaviek
    }

    /**
     * Metóda na získanie počtu riadkov v tabuľke crm
     * @return array|null Vracia počet riadkov v tabuľke
     */
    public function readCountCrm()
    {
        $total = null;
        try {
            /*Získanie celkového počtu použití v databáze*/
            $total = $this->db->query("SELECT COUNT(*) AS count_rows FROM crm;")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $err) {
        }
        return $total; // vrátiť počet použití
    }

    /**
     * Metóda na vymazanie riadku v tabuľke crm
     * @param int $id Identifikátor riadku v databáze
     * @return bool Vracia stav vymazania riadku v databáze
     */
    public function deleteCrm($id)
    {
        $data = array(
            ':id' => $id
        );
        $stmt = $this->db->prepare('DELETE FROM crm WHERE id=:id'); // odstránenie použitia z databázy podľa jeho identifikátora
        return $stmt->execute($data); // vrátenie výsledku operácie
    }

    /**
     * Metóda na vloženie dátumu odpovede do riadku v tabuľke crm
     * @param int $id Identifikátor riadku v databáze
     * @return bool Vracia stav aktualizácie riadku v databáze
     */
    public function updateCrm($id)
    {
        $data = array(
            ':id' => $id
        );
        $stmt = $this->db->prepare('UPDATE crm SET replied_at=NOW() WHERE id=:id'); // aktualizácia statusu použitia podľa jeho ID
        return $stmt->execute($data); // vrátenie výsledku operácie
    }

    /**
     * Metóda načítania zoznamu projektov z databázy bez kontroly stavu publikácie
     * @param int $offset Odsadenie od začiatku
     * @param int $limit Limit položiek v dotaze
     * @param string $lang Prípona tabuľky
     * @return array|null Vracia zoznam projektov
     */
    public function readCards($offset = -1, $limit = -1, $lang = "sk")
    {
        $lim = "";
        /*Vynútiť konverziu typu pre celočíselné parametre dotazu do databázy*/
        $offset = intval($offset);
        $limit = intval($limit);
        /*//Vynútiť konverziu typu pre celočíselné parametre dotazu do databázy*/
        /*Limity vzorkovania údajov v sql-dotazoch (na základe aktuálneho statusu stránkovania)*/
        if ($offset > -1 && $limit > 0) {
            $lim = "$offset,$limit";
        } else if ($offset === -1 && $limit > 0) {
            $lim = "$limit";
        }
        /*//Limity vzorkovania údajov v sql-dotazoch (na základe aktuálneho statusu stránkovania)*/
        $result = null;
        try {
            /*načítanie aktuálnej "stránky" projektov z databázy vrátane tých, ktoré boli stiahnuté z uverejnenia*/
            $result = $this->db->query("SELECT * FROM projects_$lang ORDER BY ordering" . (!empty($lim) ? " LIMIT $lim" : "") . ";")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $err) {
        }
        return $result; // vrátiť pole projektov
    }


    /**
     * Metóda na získanie počtu riadkov v tabuľke projects_$lang bez kontroly stavu publikácie
     * @param string $lang Prípona tabuľky
     * @return array|null Vracia počet riadkov v tabuľke
     */
    public function readCountCards($lang = "sk")
    {
        $total = null;
        try {
            /*Získanie počtu všetkých projektov v databáze vrátane tých, ktoré boli stiahnuté z uverejnenia*/
            $total = $this->db->query("SELECT COUNT(*) AS count_rows FROM projects_$lang;")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $err) {
        }
        return $total; // vrátenie statusu transakcie
    }

    /**
     * Metóda na vymazanie riadku v tabuľke projects_$lang
     * @param int $id Identifikátor riadku v tabuľke
     * @param string $lang Prípona tabuľky
     * @return bool Vracia stav vymazania riadku v tabuľke
     */
    public function deleteCard($id, $lang = "sk")
    {
        /*Generovanie požiadavky na odstránenie projektu z databázy podľa jeho id získaného z požiadavky GET z prehliadača. Všetky prepojenia medzi projektom a kategóriami budú automaticky odstránené z prepojenej tabuľky projects_has_categories_$lang prostredníctvom kaskádového parametra pre ondelete*/
        $data = array(
            ':id' => $id
        );
        $stmt = $this->db->prepare("DELETE FROM projects_$lang WHERE id=:id");
        /*Vykonanie požiadavky a vrátenie stavu operácie*/
        return $stmt->execute($data);
    }

    /**
     * Metóda aktualizácie informácií v tabuľke projects_$lang
     * @param stdClass $fields Polia formulára
     * @param string $lang Prípona tabuľky
     * @return bool Vracia stav aktualizácie riadku v tabuľke
     */
    public function updateCard($fields, $lang = "sk")
    {
        /*Vynútiť konverziu typu pre ID upravovaného projektu*/
        $id = intval($fields->id);
        try {
            /*Získanie zoznamu prepojení medzi projektom a kategóriami (jeden projekt môže mať niekoľko kategórií)*/
            $projects_cats_link = $this->db->query("SELECT * FROM projects_has_categories_$lang WHERE project_id=$id")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($projects_cats_link as $key => $link) {
                /*Cyklické prechádzanie zoznamu prepojení medzi projektmi a kategóriami*/
                if (!in_array($link["project_category_id"], $fields->project_category_ids)) {
                    /*Ak sa kategória prepojená s projektom nenachádza v zozname, ktorý bol získaný z formulára, znamená to, že toto mapovanie bolo z formulára vymazané, a preto by malo byť vymazané aj z databázy*/
                    $data = array(
                        ':project_id' => $id,
                        ':project_category_id' => $link['project_category_id']
                    );
                    /*Odstránenie neaktuálnych mapovaní z databázy*/
                    $stmt = $this->db->prepare("DELETE FROM projects_has_categories_$lang WHERE project_id=:project_id AND project_category_id=:project_category_id");
                    $stmt->execute($data);
                    /*//Odstránenie neaktuálnych mapovaní z databázy*/
                }
            }
            if(is_array($fields->project_category_ids)) {
                foreach ($fields->project_category_ids as $key => $cat) {
                    /*Prechádzanie poľa kategórií načítaných z formulára projektu*/
                    if (!in_array($cat, array_column($projects_cats_link,'project_category_id'))) {
                        /*Ak kategória získaná z formulára nie je prepojená s projektom v databáze, vytvorenie nového mapovania pre ňu*/
                        $data = array(
                            ':project_id' => $id,
                            ':project_category_id' => $cat
                        );
                        /*Vytvorenie nového prepojenia medzi projektom a kategóriou v databáze*/
                        $stmt = $this->db->prepare("INSERT INTO projects_has_categories_$lang SET project_id=:project_id, project_category_id=:project_category_id");
                        $stmt->execute($data);
                        /*//Vytvorenie nového prepojenia medzi projektom a kategóriou v databáze*/
                    }
                }
            } else {
                $cat = intval($fields->project_category_ids);
                if (!in_array($cat, ‌‌array_column($projects_cats_link,'project_category_id'))) {
                    /*Ak kategória získaná z formulára nie je prepojená s projektom v databáze, vytvorenie nového mapovania pre ňu*/
                    $data = array(
                        'id' => $id,
                        'project_category_id' => $cat
                    );
                    /*Vytvorenie nového prepojenia medzi projektom a kategóriou v databáze*/
                    $stmt = $this->db->prepare("INSERT INTO project_categories_$lang SET project_id=:id, project_category_id=:project_category_id");
                    $stmt->execute($data);
                    /*//Vytvorenie nového prepojenia medzi projektom a kategóriou v databáze*/
                }
            }
        } catch (Exception $err) {
            return false;
        }
        $data = array(
            ':id' => $id,
            ':title' => $fields->title,
            ':alias' => $fields->alias,
            ':intro_text' => $fields->intro_text,
            ':full_text' => $fields->full_text,
            ':customer' => $fields->customer,
            ':image' => $fields->image,
            ':image_ImageWidth' => $fields->image_ImageWidth,
            ':image_ImageHeight' => $fields->image_ImageHeight,
            ':meta_key' => $fields->meta_key,
            ':meta_description' => $fields->meta_description,
            ':ordering' => intval($fields->ordering),
            ':published' => $fields->published
        );
        /*Aktualizácia aktuálneho projektu v databáze pomocou údajov prijatých z prehliadača z formulára projektu*/
        $stmt = $this->db->prepare("UPDATE projects_$lang SET title=:title, alias=:alias, intro_text=:intro_text, full_text=:full_text, customer=:customer, image=:image, image_ImageWidth=:image_ImageWidth, image_ImageHeight=:image_ImageHeight, meta_key=:meta_key, meta_description=:meta_description, ordering=:ordering, published=:published WHERE id=:id");
        /*Vykonanie dotazu a vrátenie stavu aktualizácie údajov*/
        return $stmt->execute($data);
    }

    /**
     * Metóda na vloženie nového projektu do tabuľky projects_$lang
     * @param stdClass $fields Polia formulára
     * @param string $lang Prípona tabuľky
     * @return bool Vracia stav vloženia reťazca do tabuľky
     */
    public function insertCard($fields, $lang = "sk")
    {
        $data = array(
            ':title' => $fields->title,
            ':alias' => $fields->alias,
            ':intro_text' => $fields->intro_text,
            ':full_text' => $fields->full_text,
            ':customer' => $fields->customer,
            ':image' => $fields->image,
            ':image_ImageWidth' => $fields->image_ImageWidth,
            ':image_ImageHeight' => $fields->image_ImageHeight,
            ':meta_key' => $fields->meta_key,
            ':meta_description' => $fields->meta_description,
            ':ordering' => intval($fields->ordering),
            ':published' => $fields->published
        );
        /*Pridanie nového projektu do tabuľky projects_$lang*/
        $stmt = $this->db->prepare("INSERT INTO projects_$lang SET title=:title, alias=:alias, intro_text=:intro_text, full_text=:full_text, customer=:customer, image=:image, image_ImageWidth=:image_ImageWidth, image_ImageHeight=:image_ImageHeight, meta_key=:meta_key, meta_description=:meta_description, ordering=:ordering, published=:published");
        $status = $stmt->execute($data);
        if ($status) {
            $new_id = $this->db->lastInsertId(); // Získanie ID posledného rekordu vloženého do databázy
            if(is_array($fields->project_category_ids)) {
                foreach ($fields->project_category_ids as $key => $cat) {
                    /*Prechod cez ID kategórie získané z formulára*/
                    $data = array(
                        'id' => $new_id,
                        'project_category_id' => $cat
                    );
                    /*Vloženie prepojení medzi novým projektom a kategóriami v tabuľke projects_has_categories_$lang*/
                    $stmt = $this->db->prepare("INSERT INTO projects_has_categories_$lang SET project_id=:id, project_category_id=:project_category_id");
                    $stmt->execute($data);
                }
            } else {
                $data = array(
                    'id' => $new_id,
                    'project_category_id' => intval($fields->project_category_ids)
                );
                /*Vloženie prepojení medzi novým projektom a kategóriami v tabuľke projects_has_categories_$lang*/
                $stmt = $this->db->prepare("INSERT INTO projects_has_categories_$lang SET project_id=:id, project_category_id=:project_category_id");
                $stmt->execute($data);
            }
        }
        return $status; // vrátiť stav pridania nového projektu do databázy
    }

    /**
     * Metóda na čítanie informácií o projekte z tabuľky podľa jeho id
     * @param int $id Identifikátor riadku v tabuľke
     * @param string $lang Prípona tabuľky
     * @return array|null Vracia poľa informácií o projekte
     */
    public function readCard($id, $lang = "sk")
    {
        $result = null;
        try {
            /*čítanie informácií o projekte podľa ho identifikačného čísla*/
            $result = $this->db->query("SELECT * FROM projects_$lang WHERE id=$id")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $err) {
        }
        return $result; // vrátenie poľa informácií o projekte
    }

    /**
     * Metóda získania zoznamu kategórií projektov
     * @param string $lang Prípona tabuľky
     * @return array|null Vracia pole so zoznamom kategórií projektov
     */
    public function getCategories($lang = "sk")
    {
        $result = null;
        try {
            /*Čítanie zoznamu všetkých kategórií projektov*/
            $result = $this->db->query("SELECT id, title FROM project_categories_$lang")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $err) {
        }
        return $result; // vrátenie poľa so zoznamom kategórií
    }

    /**
     * Metóda na získanie zoznamu kategórií spojených s projektom podľa jeho identifikačného čísla
     * @param int $id Identifikátor riadku v tabuľke
     * @param string $lang Prípona tabuľky
     * @return array|null Vracia pole so zoznamom kategórií projektov
     */
    public function getLinkedCategories(int $id, $lang = "sk")
    {
        $result = null;
        try {
            /*Čítanie zoznamu kategórií priradených k projektu podľa jeho identifikačného čísla*/
            $result = $this->db->query("SELECT * FROM projects_has_categories_$lang WHERE project_id=$id")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $err) {
        }
        return $result; // vrátenie poľa so zoznamom kategórií
    }


}