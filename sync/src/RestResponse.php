<?php
/**
 * Created by PhpStorm.
 * User: Vinicius
 * Date: 11/04/2019
 * Time: 00:48
 */

class RestResponse implements JsonSerializable
{
    /*
     * Mensagem após evento.
     * */
    private $MSG;

    /*
     * Id do sequencial softilux.
     * */
    private $SEQILX;

    /*
     * Id do sequencial do portal web.
     * */
    private $SEQWEB;

    /**
     * RestResponse constructor.
     * @param $MSG
     * @param $SEQILX
     * @param $SEQWEB
     */
    public function __construct($MSG, $SEQILX, $SEQWEB)
    {
        $this->MSG = $MSG;
        $this->SEQILX = $SEQILX;
        $this->SEQWEB = $SEQWEB;
    }

    /**
     * @return mixed
     */
    public function getMSG()
    {
        return $this->MSG;
    }

    /**
     * @param mixed $MSG
     */
    public function setMSG($MSG)
    {
        $this->MSG = $MSG;
    }

    /**
     * @return mixed
     */
    public function getSEQILX()
    {
        return $this->SEQILX;
    }

    /**
     * @param mixed $SEQILX
     */
    public function setSEQILX($SEQILX)
    {
        $this->SEQILX = $SEQILX;
    }

    /**
     * @return mixed
     */
    public function getSEQWEB()
    {
        return $this->SEQWEB;
    }

    /**
     * @param mixed $SEQWEB
     */
    public function setSEQWEB($SEQWEB)
    {
        $this->SEQWEB = $SEQWEB;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}