Here’s a documentation outline for your component structure in a Vue.js project with a focus on atomic design principles and a golden theme for a premium clothing eCommerce application.

---

## Component Structure Documentation

### Overview

This documentation provides a comprehensive overview of the component structure used in our Vue.js eCommerce application. The structure is based on atomic design principles, ensuring reusable, scalable, and maintainable components.

### Folder Structure

```
src/
│
├── assets/
│   ├── images/
│   ├── styles/
│
├── components/
│   ├── atoms/
│   │   ├── ButtonComponent.vue
│   │   ├── InputComponent.vue
│   │   ├── IconComponent.vue
│   │   └── BadgeComponent.vue
│   │
│   ├── molecules/
│   │   ├── CardComponent.vue
│   │   ├── ModalComponent.vue
│   │   ├── NavbarComponent.vue
│   │   ├── RatingComponent.vue
│   │   └── CartItemComponent.vue
│   │
│   ├── organisms/
│   │   ├── ProductListComponent.vue
│   │   ├── FooterComponent.vue
│   │   ├── BannerComponent.vue
│   │   ├── CartComponent.vue
│   │   └── CheckoutComponent.vue
│   │
│   ├── templates/
│   │   ├── MainTemplate.vue
│   │   └── ProductTemplate.vue
│   │
│   ├── pages/
│   │   ├── HomePage.vue
│   │   ├── ProductPage.vue
│   │   ├── CartPage.vue
│   │   ├── CheckoutPage.vue
│   │   └── AboutPage.vue
│
├── App.vue
├── main.js
└── router/
    └── index.js
```

### Components

#### **Atoms**

- **ButtonComponent.vue**
  - A reusable button component.
  - **Props**: `color`, `size`, `disabled`, `type`
  - **Usage**: Buttons for various actions, customizable with colors and sizes.

- **InputComponent.vue**
  - A reusable input field component.
  - **Props**: `type`, `id`, `label`, `value`, `placeholder`
  - **Usage**: Form inputs with labels and placeholders.

- **IconComponent.vue**
  - A component for displaying icons.
  - **Props**: `name`, `size`, `color`
  - **Usage**: Icons from libraries like Font Awesome.

- **BadgeComponent.vue**
  - A component for displaying badges.
  - **Props**: `color`
  - **Usage**: Badges for notifications, labels, or status indicators.

#### **Molecules**

- **CardComponent.vue**
  - A component for displaying product cards.
  - **Props**: `title`, `image`, `price`
  - **Usage**: Showcasing individual products with images and prices.

- **ModalComponent.vue**
  - A modal dialog component.
  - **Props**: `isVisible`, `title`, `content`, `footer`
  - **Usage**: Displaying modals for forms, alerts, or confirmations.

- **NavbarComponent.vue**
  - A navigation bar component.
  - **Usage**: Site-wide navigation with links and a shopping cart icon.

- **RatingComponent.vue**
  - A component for displaying product ratings.
  - **Props**: `rating`, `maxStars`
  - **Usage**: Show star ratings for products.

- **CartItemComponent.vue**
  - A component for displaying items in the cart.
  - **Props**: `product`
  - **Usage**: Show cart items with options to remove.

#### **Organisms**

- **ProductListComponent.vue**
  - A component for displaying a list of products.
  - **Props**: `products`
  - **Usage**: Rendering multiple product cards.

- **FooterComponent.vue**
  - A footer component for site-wide information.
  - **Usage**: Site footer with links and contact information.

- **BannerComponent.vue**
  - A component for promotional banners.
  - **Props**: `title`, `subtitle`, `buttonText`
  - **Usage**: Displaying promotional content or calls to action.

- **CartComponent.vue**
  - A component for displaying the shopping cart.
  - **Props**: `cartItems`, `total`
  - **Usage**: Overview of items in the cart and total cost.

- **CheckoutComponent.vue**
  - A component for the checkout process.
  - **Usage**: Form for completing the purchase with input fields for user details.

#### **Templates**

- **MainTemplate.vue**
  - The main layout template for the application.
  - **Usage**: Includes header, footer, and a slot for page content.

- **ProductTemplate.vue**
  - A layout template specifically for product pages.
  - **Usage**: Layout for displaying detailed product information.

#### **Pages**

- **HomePage.vue**
  - The landing page of the application.
  - **Usage**: Displays featured products, banners, and promotional content.

- **ProductPage.vue**
  - The page for displaying individual product details.
  - **Usage**: Detailed view of a single product with options to add to the cart.

- **CartPage.vue**
  - The page for viewing and managing the shopping cart.
  - **Usage**: Shows items in the cart, total cost, and checkout button.

- **CheckoutPage.vue**
  - The page for completing the purchase process.
  - **Usage**: Checkout form with payment and shipping details.

- **AboutPage.vue**
  - The page providing information about the company or brand.
  - **Usage**: Contains the brand’s mission, history, and other relevant information.

### Styling and Theme

- **Golden Theme**: The golden color (#ffd700) is used for primary actions, headings, and important elements to highlight the premium aspect of the brand.
- **Black and Gold**: The main color scheme consists of black backgrounds with golden accents for a luxurious feel.

### Usage

1. **Importing Components**: Import the required components into your Vue files as needed.
2. **Props and Customization**: Use the props defined for each component to customize their behavior and appearance.
3. **Consistency**: Maintain consistency in styling and usage across the application to provide a cohesive user experience.

---

Feel free to adjust the details to match your specific needs and preferences. This documentation should serve as a guide for understanding and using the component structure effectively in your project.
