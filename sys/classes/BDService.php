<?php

class BDService
{
    /**
     * @var BDService
     */
    private static $sysBD = null;

    /**
     * @var PDO
     */
    private $pdo;
    /**
     * @var string
     */
    private $error;
    /**
     * @var int
     */
    private $affected_rows;

    /**
     * @param string $user
     * @param string $pass
     * @param string $dbName
     * @param string $host
     * @param string $charset
     * @return BDService
     * @example  BDService::createPDOConnection() -> usa os dados de Config para definir uma instância...
     */
    public static function createPDOConnection($user = DB_USER, $pass = DB_PASS, $dbName = DB_NAME, $host = DB_HOST, $charset = 'utf8mb4') {
        BDService::$sysBD = new BDService($user, $pass, $dbName, $host, $charset);
        return BDService::$sysBD;
    }

    public static function getSysBD() {
        return BDService::$sysBD ?? static::createPDOConnection();
    }

    protected function __construct($user, $pass, $dbName, $host = "localhost", $charset = 'utf8mb4') {
        // string de conexão
        $strConexao = sprintf("mysql:dbname=%s;host=%s;charset=%s",
                              $dbName,
                              $host,
                              $charset
        );

        $this->pdo = null;
        $this->error = '';
        $this->affected_rows = 0;

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            // $pdo — instância da classe PDO
            $this->pdo = new PDO($strConexao, $user, $pass, $options);
        } catch (PDOException $e) {
            $this->error = "Erro na DB: " . $e->getMessage();
        } catch (Exception $e) {
            $this->error = "erro genérico: " . $e->getMessage();
        }
    }

    /**
     * @return PDO
     */
    public function getPdo() { return $this->pdo; }

    /**
     * @return string
     */
    public function getError() { return $this->error; }

    /**
     * @return bool
     */
    public function hasError() { return !empty($this->getError()); }

    /**
     * @return int
     */
    public function getAffectedRows(): int { return $this->affected_rows; }

    /**
     * @return int
     */
    public function getInsertId(): int { return $this->pdo->lastInsertId(); }

    /**
     * @param string $sql
     * @param array $params
     */
    public function execQuery($sql, $params = []) {
        $ret = false;
        if ( !$this->hasError()) {

            $stmt = $this->getPdo()->prepare($sql);

            $ret = $stmt->execute($params);

            $this->affected_rows = $stmt->rowCount();
        }
        return $ret;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array|false
     */
    public function fetchQuery($sql, $params = []) {
        $ret = [];

        if ( !$this->hasError()) {

            $stmt = $this->getPdo()->prepare($sql);

            $stmt->execute($params);

            $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $this->affected_rows = $stmt->rowCount();
        }
        return $ret;
    }

    public function fetchAll($tbl_name) {

        return $this->fetchQuery(sprintf("SELECT * FROM %s", $tbl_name));
    }

    public function fetchById($tbl_name, $id) {

        return $this->fetchQuery(
            sprintf("SELECT * FROM %s WHERE id=:id;", $tbl_name),
            ['id' => $id]
        );
    }
}

/**
 * @return BDService
 */
function bd(): BDService { return BDService::getSysBD(); }