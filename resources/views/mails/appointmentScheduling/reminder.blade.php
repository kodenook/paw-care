<x-mail::message>
Dear {{ $appointmentScheduling->owner_name }},

I hope this message finds you well. We're reaching out to remind you of an **important appointment** for {{ $appointmentScheduling->pet_name }} scheduled for **{{ $appointmentScheduling->date }}** at **{{ $appointmentScheduling->time }}** Hrs. at our veterinary clinic.

We understand the significance of your pet's care, and we want to ensure they receive the best possible attention. Our team is ready to provide care for {{ $appointmentScheduling->pet_name }} and address any medical concerns you may have.

Please note the **date and time of the appointment** and ensure you arrive promptly. If you need to **reschedule the appointment or have any questions**, please don't hesitate to contact us as soon as possible.

We look forward to seeing you and {{ $appointmentScheduling->pet_name }} at the clinic and are eager to provide them with the care they deserve!

**Best regards**,<br>
{{ config('app.name') }}
</x-mail::message>
