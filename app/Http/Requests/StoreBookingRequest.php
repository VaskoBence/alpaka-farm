<?php

namespace App\Http\Requests;

use App\Models\Booking;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'visit_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'visit_time' => [
                'required',
                Rule::in([
                    '10:00',
                    '12:00',
                    '14:00',
                    '16:00',
                ]),
            ],
            'guests' => ['required', 'integer', 'min:1', 'max:10'],
            'message' => ['nullable', 'string', 'max:2000'],
        ];
    }

    /**
     * Az idősáv teljes kapacitása legfeljebb 10 fő.
     * A lemondott foglalások nem foglalnak helyet.
     *
     * @return array<int, callable(Validator): void>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if ($validator->errors()->hasAny([
                    'visit_date',
                    'visit_time',
                    'guests',
                ])) {
                    return;
                }

                $reservedGuests = Booking::query()
                    ->whereDate('visit_date', $this->input('visit_date'))
                    ->where('visit_time', $this->input('visit_time'))
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->sum('guests');

                $requestedGuests = (int) $this->input('guests');

                if ($reservedGuests + $requestedGuests > 10) {
                    $remainingPlaces = max(0, 10 - $reservedGuests);

                    $validator->errors()->add(
                        'guests',
                        $remainingPlaces > 0
                            ? "Erre az időpontra már csak {$remainingPlaces} szabad hely maradt."
                            : 'Ez az időpont már betelt. Válassz másik időpontot.'
                    );
                }
            },
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'visit_date.after_or_equal' =>
                'Csak mai vagy későbbi napra foglalhatsz.',
            'visit_time.in' =>
                'Csak 10:00, 12:00, 14:00 vagy 16:00 választható.',
            'guests.min' =>
                'Legalább egy vendéget adj meg.',
            'guests.max' =>
                'Egy foglalásban legfeljebb 10 vendég szerepelhet.',
        ];
    }
}