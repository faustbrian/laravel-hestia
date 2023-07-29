<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Mail;

use BombenProdukt\Hestia\Models\TeamInvitation as TeamInvitationModel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

final class TeamInvitation extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public readonly TeamInvitationModel $invitation) {}

    public function content(): Content
    {
        return new Content(
            view: 'emails.team-invitation',
            with: ['acceptUrl' => URL::signedRoute('team-invitations.accept', ['invitation' => $this->invitation])],
        );
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('Team Invitation'),
        );
    }
}
