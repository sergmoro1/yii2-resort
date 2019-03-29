<?php

namespace sergmoro1\resort\models;

use Yii;
use yii\base\Model;
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
            [['check_in', 'check_out', 'adults', 'first_name', 'phone', 'location'], 'required'],
			['check_in', 'date', 'timestampAttribute' => 'check_in'],
			['check_out', 'date', 'timestampAttribute' => 'check_out'],
            [['fund_id', 'adults', 'children'], 'integer'],
            ['adults', 'default', 'value' => 1],
            ['children', 'default', 'value' => 0],
            [['first_name', 'last_name', 'email', 'location'], 'string', 'max' => 128],
            ['phone', 'string', 'length' => [11, 13]],
            ['phone', 'match', 'pattern' => '/^\+{0,1}\d{11,13}$/', 'message' => Yii::t('app', 
				'The phone number should consist from 11 to 13 digits and may be prepended with +.')],
            ['requirements', 'string', 'max' => 512],
            ['email', 'email'],
            ['agree', 'match', 'pattern' => '/^1$/', 'message' => \Yii::t('app', 'Please confirm that you agree to the processing of data sent by you.')],
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'check_in' => \Yii::t('app', 'Arrival date'),
			'check_out' => \Yii::t('app', 'Departure date'),
			'adults' => \Yii::t('app', 'Adults'),
			'children' => \Yii::t('app', 'Children'),
			'first_name' => \Yii::t('app', 'First Name'),
			'last_name' => \Yii::t('app', 'Last Name'),
			'phone' => \Yii::t('app', 'Phone'),
			'location' => \Yii::t('app', 'Location'),
			'requirements' => \Yii::t('app', 'Special requirements'),
			'agree' => \Yii::t('app', 'Consent to the processing of sent data'),
            'verifyCode' => \Yii::t('app', 'Verification Code'),
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
		$from[$this->email] = $full_name;
		if($this->fund_id) {
			$room = Fund::findOne($this->fund_id);
			$choice = Lookup::item('HotelName', $room->hotel_id) . ', ' . Lookup::item('RoomCategory', $room->category);
		} else
			$choice = \Yii::t('app', 'No room reservation');

		$this->days = floor(($this->check_out - $this->check_in)/(3600*24));
		$this->check_in = date('d.m.Y', $this->check_in);
		$this->check_out = date('d.m.Y', $this->check_out);

		$subject = "Заказ: $choice, {$this->check_in} - {$this->check_out}.";

        \Yii::$app->mailer->setViewPath('@vendor/sergmoro1/yii2-resort/src/mail');

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
            ->setSubject($subject)
            ->send();
    }
}
