<?php

namespace sergmoro1\resort\models;

use Yii;
use yii\base\Model;

use sergmoro1\resort\Module;
use common\models\Fund;
use sergmoro1\lookup\models\Lookup;

/**
 * ReservationForm is the model behind the reservation form.
 */
class ReservationForm extends Model
{
    public $fund_id;
    public $check_in;
    public $check_out;
    public $adults;
    public $children;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $location;
    public $requirements;
    public $agree;
    public $verifyCode;

    public $days;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['check_in', 'check_out', 'adults', 'first_name', 'phone', 'email', 'location'], 'required'],
            ['check_in', 'date', 'format' => 'php: d.m.Y', 'timestampAttribute' => 'check_in'],
            ['check_out', 'date', 'format' => 'php: d.m.Y', 'timestampAttribute' => 'check_out'],
            [['fund_id', 'adults', 'children'], 'integer'],
            ['adults', 'default', 'value' => 1],
            ['children', 'default', 'value' => 0],
            [['first_name', 'last_name', 'email', 'location'], 'string', 'max' => 128],
            ['phone', 'string', 'length' => [11, 13]],
            ['phone', 'match', 'pattern' => '/^\+{0,1}\d{11,13}$/', 'message' => Module::t('core', 
                'The phone number should consist from 11 to 13 digits and may be prepended with +.')],
            ['requirements', 'string', 'max' => 512],
            ['email', 'email'],
            ['agree', 'match', 'pattern' => '/^1$/', 'message' => Module::t('core', 'Please confirm that you agree to the processing of data sent by you.')],
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'check_in' => Module::t('core', 'Arrival date'),
            'check_out' => Module::t('core', 'Departure date'),
            'adults' => Module::t('core', 'Adults'),
            'children' => Module::t('core', 'Children'),
            'first_name' => Module::t('core', 'First Name'),
            'last_name' => Module::t('core', 'Last Name'),
            'phone' => Module::t('core', 'Phone'),
            'location' => Module::t('core', 'Location'),
            'requirements' => Module::t('core', 'Special requirements'),
            'agree' => Module::t('core', 'Consent to the processing of sent data'),
            'verifyCode' => Module::t('core', 'Verification Code'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  array $contact the target email address and name
     * @return boolean whether the email was sent
     */
    public function sendEmail($contact)
    {
        $full_name = $this->first_name . ' ' . $this->last_name;
        // first email address should be admin@domain.com because from other email address mail can't be sent
        $from = [Yii::$app->params['email']['from'] => $full_name];
        // add real sender
        // $from[$this->email] = $full_name;
        $real_sender = $full_name .' <'. $this->email .'>';
        if($this->fund_id) {
            $room = Fund::findOne($this->fund_id);
            $choice = Lookup::item('HotelName', $room->hotel_id) . ', ' . Lookup::item('RoomCategory', $room->category);
        } else
            $choice = Module::t('core', 'No room reservation');

        $this->check_in = strtotime($this->check_in);
        $this->check_out = strtotime($this->check_out);
        $this->days = floor(($this->check_out - $this->check_in)/(3600*24));
        $this->check_in = date('d.m.Y', $this->check_in);
        $this->check_out = date('d.m.Y', $this->check_out);

        $subject = Module::t('core', 'Order') . ": $choice, {$this->check_in} - {$this->check_out}.";

        Yii::$app->mailer->setViewPath('@vendor/sergmoro1/yii2-resort/src/mail');

        return Yii::$app->mailer
            ->compose(
                [
                    'html' => 'reservation-details-html', 
                    'txt' => 'reservation-details-txt'
                ], 
                ['model' => $this, 'choice' => $choice]
            )
            ->setTo($contact)
            ->setFrom($from)
            ->setSubject($real_sender . ' ' . $subject)
            ->send();
    }
}
