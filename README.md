# LesVol

LesVol is a web-based volunteer activity management platform. The application helps connect individuals looking to organize volunteer activities ("seekers") with volunteers who wish to participate in social initiatives.

Through LesVol, users can search for available volunteer activities, view activity details, register as volunteers, and manage their participation. Users can also act as "seekers" to organize and manage volunteer activities.

## Main Features

- User registration and login
- Browse volunteer activities
- Search available activities
- View activity details
- Register for volunteer activities
- Create volunteer activities as a Seeker
- Manage activity participants
- Upload attendance documentation
- View volunteer portfolio

## Technology Stack

- Laravel
- PHP
- MySQL
- Blade
- HTML
- CSS
- JavaScript

## How to Run the Application

### 1. Clone the Repository

```bash
git clone https://github.com/toooobay/LesVol.git
cd LesVol
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Create Environment File

```bash
cp .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Configure Database

Create a new MySQL database, then update the `DB_DATABASE`, `DB_USERNAME` and `DB_PASSWORD` values in the `.env` file.

Example:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lesvol
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Run Migration

```bash
php artisan migrate
```

### 7. Create Storage Link

```bash
php artisan storage:link
```

### 8. Run the Application

```bash
php artisan serve
```

Open the application in your browser:

```text
http://127.0.0.1:8000
```

## Project Documentation

Complete project documentation can be accessed through the project portfolio and proposal document.

- Project Portfolio / Notion: https://app.notion.com/p/Laporan-AOL-Software-Engineering-36a59b0507ec806696f2c333ce76d323
- PKM-KC Proposal: https://docs.google.com/document/d/1KRfemZLdjPkWwTFk5tSxFNm0wSk3xifH/edit?usp=sharing
- Testing Spreadsheet : https://docs.google.com/spreadsheets/d/1NO7zcEdKrIbHa5DrCVazBHAAcdQUVhmXMVt_0S8tt1U/edit?usp=sharing

## Credits

LesVol was originally built as a team project by:

- Rafael Tobias Gosal
- earleneagesthasugeng
- Adriel Agustinus Jie
- Darian Wiratama
