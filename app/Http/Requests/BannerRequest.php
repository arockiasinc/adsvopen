<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'copy' => ['nullable', 'string', 'max:1500'],
            'detail' => ['nullable', 'string', 'max:1000'],
            'footer' => ['nullable', 'string', 'max:1000'],
            'highlights' => ['nullable', 'string', 'max:2000'],
            'button_rows' => ['nullable', 'string', 'max:2500'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:999'],
            'image' => [
                $this->isMethod('post') ? 'required' : 'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp,svg',
                'max:5120',
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function bannerData(): array
    {
        $validated = $this->validated();

        unset($validated['image']);

        $validated['highlights'] = $this->normalizeLines($validated['highlights'] ?? null);
        $validated['button_rows'] = $this->normalizeButtonRows($validated['button_rows'] ?? null);

        return $validated;
    }

    /**
     * @return array<int, string>
     */
    protected function normalizeLines(?string $value): array
    {
        if ($value === null || trim($value) === '') {
            return [];
        }

        return collect(preg_split('/\r\n|\r|\n/', $value) ?: [])
            ->map(fn (string $line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }

    /**
     * @return array<int, array<int, string>>
     */
    protected function normalizeButtonRows(?string $value): array
    {
        if ($value === null || trim($value) === '') {
            return [];
        }

        return collect(preg_split('/\r\n|\r|\n/', $value) ?: [])
            ->map(function (string $row): array {
                return collect(explode('|', $row))
                    ->map(fn (string $item) => trim($item))
                    ->filter()
                    ->values()
                    ->all();
            })
            ->filter(fn (array $row) => $row !== [])
            ->values()
            ->all();
    }
}
