<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistroCodigo extends Notification
{
	use Queueable;

	private $user;
	private $cliente;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct($user, $cliente, $elCodigo)
	{
		$this->user = $user;
		$this->cliente = $cliente;
		$this->elCodigo = $elCodigo;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
		return ['mail'];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable)
	{
		return (new MailMessage)->markdown('emails.user.codigo', ['user' => $this->user, 'cliente' => $this->cliente, 'codigo' => $this->elCodigo])->subject('Bienvenido a '.$this->cliente->cliente);
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function toArray($notifiable)
	{
		return [
			//
		];
	}
}
