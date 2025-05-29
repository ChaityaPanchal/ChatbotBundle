# Chatbot Bundle

A Symfony bundle that provides a menu-based chatbot widget with category management and FAQ functionality. The chatbot appears as a floating button on the right side of your website and allows users to browse categories and get answers to frequently asked questions.

## Features

- 🤖 Interactive chatbot widget
- 📁 Category management system
- ❓ FAQ management with category-wise organization
- 🎨 Design with floating button interface
- 🔧 Easy integration with existing Symfony projects

## Installation

### Step 1: Install the Bundle

Install the chatbot bundle using Composer:

```bash
composer require chatbot/chatbot-bundle
```

### Step 2: Register the Bundle

Add the bundle to your `config/bundles.php` file:

```php
<?php

return [
    // ... other bundles
    Chatbot\ChatbotBundle\ChatbotBundle::class => ['all' => true],
];
```

### Step 3: Configure Twig

Update your `config/packages/twig.yaml` file to include the bundle's templates:

```yaml
twig:
    file_name_pattern: '*.twig'
    paths:
        '%kernel.project_dir%/vendor/chatbot/chatbot-bundle/src/Resources/views': ChatbotBundle
```

### Step 4: Add the Chatbot Widget

Include the chatbot widget in your base template (`templates/base.html.twig`). Add this line after the opening `<body>` tag:

```twig
{{ include('@ChatbotBundle/chatbot_widget.html.twig') }}
```

Example:
```twig
<!DOCTYPE html>
<html>
<head>
    <!-- head content -->
</head>
<body>
    {{ include('@ChatbotBundle/chatbot_widget.html.twig') }}
    
    <!-- rest of your body content -->
</body>
</html>
```

### Step 5: Install Assets

Install the bundle's assets to make them publicly accessible:

```bash
php bin/console assets:install --symlink
```

This will create the necessary asset files in your `public/bundles/` directory.

### Step 6: Create and Run Migrations

Generate migrations for the chatbot database tables:

```bash
php bin/console make:migration
```

Apply the migrations to create the required database tables:

```bash
php bin/console doctrine:migrations:migrate
```

## Usage

### Managing Categories

Navigate to `/chatbot/category` to access the category management interface where you can:

- **Add new categories**: Create different topic categories for your FAQ
- **Edit existing categories**: Modify category names
- **Delete categories**: Remove categories that are no longer needed

### Managing FAQs

Navigate to `/chatbot/faq` to manage your questions and answers:

- **Add FAQ items**: Create question-answer pairs for specific categories
- **Edit FAQ items**: Modify existing questions and answers
- **Delete FAQ items**: Remove outdated or incorrect information
- **Organize by category**: Assign each FAQ to a specific category

### User Interaction

Once configured, users will see:

1. A chatbot icon/button on the right side of every page
2. Clicking the button opens the chatbot interface
3. Users can browse categories to find relevant topics
4. Select categories to view related FAQ items
5. Get instant answers to their questions

## Configuration

### Routes

The bundle provides the following routes:

- `/chatbot/category` - Category management
- `/chatbot/faq` - FAQ management

### Database Tables

The bundle creates two main database tables:

- `chatbot_category` - Stores category information
- `chatbot_faq` - Stores FAQ items with category relationships

## Customization

### Styling

You can customize the chatbot's appearance by overriding the default styles. The bundle uses standard CSS classes that you can target in your own stylesheets.

### Templates

To customize the chatbot templates, copy them from the bundle to your `templates/bundles/ChatbotBundle/` directory and modify as needed.

### Translations

The bundle supports internationalization. Add your translations to the appropriate translation files in your project.

## Requirements

- PHP 7.4 or higher
- Symfony 5.0 or higher
- Doctrine ORM
- Twig templating engine

## Troubleshooting

### Assets Not Loading

If the chatbot assets are not loading properly:

1. Ensure you've run `php bin/console assets:install --symlink`
2. Check that the `public/bundles/chatbot/` directory exists
3. Verify your web server has permission to access the assets

### Database Issues

If you encounter database-related errors:

1. Ensure your database connection is properly configured
2. Run `php bin/console doctrine:schema:validate` to check for issues
3. Clear the cache with `php bin/console cache:clear`

### Template Not Found

If Twig templates are not found:

1. Verify the Twig configuration in `config/packages/twig.yaml`
2. Check that the bundle is properly registered in `config/bundles.php`
3. Clear the Twig cache

## Contributing

Contributions are welcome! Please feel free to submit pull requests or open issues for bugs and feature requests.

## License

This bundle is released under the MIT License. See the LICENSE file for details.

## Support

For support and questions, please open an issue on the project repository or contact the development team.

---

**Happy chatting! 🤖**