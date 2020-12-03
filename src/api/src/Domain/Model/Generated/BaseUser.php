<?php
/**
 * This file has been automatically generated by TDBM.
 *
 * DO NOT edit this file, as it might be overwritten.
 * If you need to perform changes, edit the User class instead!
 */

declare(strict_types=1);

namespace App\Domain\Model\Generated;

use App\Domain\Model\ResetPasswordToken;
use TheCodingMachine\TDBM\AbstractTDBMObject;
use TheCodingMachine\TDBM\ResultIterator;
use TheCodingMachine\TDBM\AlterableResultIterator;
use Ramsey\Uuid\Uuid;
use JsonSerializable;
use TheCodingMachine\TDBM\Schema\ForeignKeys;
use TheCodingMachine\GraphQLite\Annotations\Field as GraphqlField;

/**
 * The BaseUser class maps the 'users' table in database.
 */
abstract class BaseUser extends \TheCodingMachine\TDBM\AbstractTDBMObject implements JsonSerializable
{

    /**
     * @var \TheCodingMachine\TDBM\Schema\ForeignKeys
     */
    private static $foreignKeys = null;

    /**
     * The constructor takes all compulsory arguments.
     *
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $locale
     * @param string $role
     */
    public function __construct(string $firstName, string $lastName, string $email, string $locale, string $role)
    {
        parent::__construct();
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        $this->setEmail($email);
        $this->setLocale($locale);
        $this->setRole($role);
        $this->setId(Uuid::uuid1()->toString());
    }

    /**
     * The getter for the "id" column.
     *
     * @return string
     * @GraphqlField (outputType = "ID")
     */
    public function getId() : string
    {
        return $this->get('id', 'users');
    }

    /**
     * The setter for the "id" column.
     *
     * @param string $id
     */
    public function setId(string $id) : void
    {
        $this->set('id', $id, 'users');
    }

    /**
     * The getter for the "first_name" column.
     *
     * @return string
     * @GraphqlField
     */
    public function getFirstName() : string
    {
        return $this->get('first_name', 'users');
    }

    /**
     * The setter for the "first_name" column.
     *
     * @param string $firstName
     */
    public function setFirstName(string $firstName) : void
    {
        $this->set('first_name', $firstName, 'users');
    }

    /**
     * The getter for the "last_name" column.
     *
     * @return string
     * @GraphqlField
     */
    public function getLastName() : string
    {
        return $this->get('last_name', 'users');
    }

    /**
     * The setter for the "last_name" column.
     *
     * @param string $lastName
     */
    public function setLastName(string $lastName) : void
    {
        $this->set('last_name', $lastName, 'users');
    }

    /**
     * The getter for the "email" column.
     *
     * @return string
     * @GraphqlField
     */
    public function getEmail() : string
    {
        return $this->get('email', 'users');
    }

    /**
     * The setter for the "email" column.
     *
     * @param string $email
     */
    public function setEmail(string $email) : void
    {
        $this->set('email', $email, 'users');
    }

    /**
     * The getter for the "password" column.
     *
     * @return string|null
     */
    public function getPassword() : ?string
    {
        return $this->get('password', 'users');
    }

    /**
     * The setter for the "password" column.
     *
     * @param string|null $password
     */
    public function setPassword(?string $password) : void
    {
        $this->set('password', $password, 'users');
    }

    /**
     * The getter for the "locale" column.
     *
     * @return string
     * @GraphqlField
     */
    public function getLocale() : string
    {
        return $this->get('locale', 'users');
    }

    /**
     * The setter for the "locale" column.
     *
     * @param string $locale
     */
    public function setLocale(string $locale) : void
    {
        $this->set('locale', $locale, 'users');
    }

    /**
     * The getter for the "role" column.
     *
     * @return string
     * @GraphqlField
     */
    public function getRole() : string
    {
        return $this->get('role', 'users');
    }

    /**
     * The setter for the "role" column.
     *
     * @param string $role
     */
    public function setRole(string $role) : void
    {
        $this->set('role', $role, 'users');
    }

    /**
     * Returns the ResetPasswordToken pointing to this bean via the user_id column.
     *
     * @
     */
    public function getResetPasswordToken() : ?\App\Domain\Model\ResetPasswordToken
    {
        return $this->retrieveManyToOneRelationshipsStorage('reset_password_tokens', 'from__user_id__to__table__users__columns__id', ['reset_password_tokens.user_id' => $this->get('id', 'users')])->first();
    }

    /**
     * Internal method used to retrieve the list of foreign keys attached to this bean.
     */
    protected static function getForeignKeys(string $tableName) : \TheCodingMachine\TDBM\Schema\ForeignKeys
    {
        if ($tableName === 'users') {
            if (self::$foreignKeys === null) {
                self::$foreignKeys = new ForeignKeys([

                ]);
            }
            return self::$foreignKeys;
        }
        return parent::getForeignKeys($tableName);
    }

    /**
     * Serializes the object for JSON encoding.
     *
     * @param bool $stopRecursion Parameter used internally by TDBM to stop embedded
     * objects from embedding other objects.
     * @return array
     */
    public function jsonSerialize(bool $stopRecursion = false)
    {
        $array = [];
        $array['id'] = $this->getId();
        $array['firstName'] = $this->getFirstName();
        $array['lastName'] = $this->getLastName();
        $array['email'] = $this->getEmail();
        $array['password'] = $this->getPassword();
        $array['locale'] = $this->getLocale();
        $array['role'] = $this->getRole();
        return $array;
    }

    /**
     * Returns an array of used tables by this bean (from parent to child
     * relationship).
     *
     * @return string[]
     */
    public function getUsedTables() : array
    {
        return [ 'users' ];
    }

    public function __clone()
    {
        parent::__clone();
        $this->setId(Uuid::uuid1()->toString());
    }
}
