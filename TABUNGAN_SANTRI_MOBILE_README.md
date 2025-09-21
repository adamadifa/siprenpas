# Tabungan Santri Mobile View

## Overview

This feature provides a mobile-optimized view for students (santri) to view their savings accounts with a credit card-style design.

## Features

-   **Credit Card Style Design**: Cards with 16:9 aspect ratio similar to credit cards
-   **Jenis Tabungan Display**: Shows the type of savings (e.g., "Tabungan Siswa", "Tabungan Qurban") instead of the savings name
-   **Responsive Design**: Optimized for mobile devices
-   **Swiper Integration**: Horizontal scrolling through multiple savings accounts
-   **Transaction History**: Shows the last 5 transactions

## Files Created/Modified

### New Files

1. `resources/views/koperasi/tabungan/santri-mobile.blade.php` - Mobile view template
2. `TABUNGAN_SANTRI_MOBILE_README.md` - This documentation

### Modified Files

1. `app/Http/Controllers/Api/TabunganSantriController.php` - Added `showMobile()` method
2. `routes/web.php` - Added route for mobile view

## Usage

### Route

```
GET /tabungan-santri/{id_siswa}/mobile
```

### Example URL

```
/tabungan-santri/2024001/mobile
```

### Controller Method

The `showMobile()` method in `TabunganSantriController` handles the mobile view:

-   Fetches student data by `id_siswa`
-   Retrieves all savings accounts for the student
-   Calculates total balance across all accounts
-   Fetches the last 5 transactions from all accounts
-   Returns the mobile view with data

## Design Features

### Credit Card Styling

-   **Aspect Ratio**: 16:9 (credit card proportions)
-   **Gradient Backgrounds**: Different colors for each card
-   **Chip Design**: Visual chip element on each card
-   **Card Number**: Masked account number display
-   **Validity**: Shows "Unlimited" validity
-   **Shimmer Effect**: Subtle animation on cards

### Card Information Display

-   **Jenis Tabungan**: Type of savings (e.g., "Tabungan Siswa", "Tabungan Qurban")
-   **Account Number**: Masked for security
-   **Balance**: Formatted currency display
-   **Student Name**: Account holder name

### Responsive Elements

-   **Swiper Integration**: Horizontal scrolling through cards
-   **Mobile-First Design**: Optimized for mobile screens
-   **Touch-Friendly**: Large touch targets and smooth scrolling

## Data Structure

The view expects the following data structure:

```php
$data = [
    'siswa' => [
        'id_siswa' => '2024001',
        'nama_lengkap' => 'Student Name',
        'nis' => '20240001',
        'kelas' => 'X-A'
    ],
    'total_saldo' => 500000,
    'jumlah_rekening' => 2,
    'tabungan' => [
        [
            'no_rekening' => '001-2024001001',
            'saldo' => 250000,
            'jenis_tabungan' => [
                'jenis_tabungan' => 'Tabungan Siswa'
            ],
            'anggota' => [
                'nama_lengkap' => 'Student Name'
            ]
        ]
    ]
];
```

## Styling

The view includes comprehensive CSS for:

-   Credit card appearance
-   Gradient backgrounds
-   Chip design
-   Card animations
-   Responsive layout
-   Swiper integration

## Integration

To integrate this feature into your application:

1. Ensure the route is accessible
2. Link to the mobile view from your student dashboard
3. Pass the student ID (`id_siswa`) as a parameter
4. The view will automatically fetch and display the student's savings data

## Example Integration

```php
// In your student dashboard or navigation
<a href="{{ route('tabungan-santri.mobile', $siswa->id_siswa) }}" class="btn btn-primary">
    View Savings (Mobile)
</a>
```

## Notes

-   The view requires authentication (inherits from mobile layout)
-   Data is fetched from the existing database structure
-   Compatible with the existing API structure
-   Uses the same formatting functions as other views

