# wc-order-status

Adding custom order statuses to the Woocommerce platform could be definitely easier - and I am not talking about installing yet another plugin for dealing with silly tasks. This helper aims to automate and incept some intelligence to the way developers and web designers add, manage, style and even link behaviours and reactions to the custom statuses created.

First and foremost, we established a class to make the painful routine of adding custom statuses a single line of code.

# Installation

No additional plugins, please. This library can be installed using Composer or, if you prefer, just download the main class `OrderStatus` and add to your project.

# Usage

By definition, for adding a new status to WC orders we first need to register such status in Wordpress, and then include the newly added status to the pool where order statuses are saved within Woocommerce. So... why not doing that at once, instead of successive functions and hooks?