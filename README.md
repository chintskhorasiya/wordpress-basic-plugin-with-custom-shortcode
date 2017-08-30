# Basic example of wordpress plugin to select, update, insert and delete from database (CRUD) and also basic shortcode

This example works with a **custom table** in the wordpress database. it’s  written with simplicity in mind so you can understand everithing quickly.

This plugin shows you how to add your custom shortcode in wordpress website.

Includes the following files

*   **init** – plugin initialization, where everything is put toghether
*   **list** – showing a list of items
*   **update** – for updating and deleting items
*   **create** – for inserting new items
*   **style-admin.css** – stylesheet to use in the admin screens

There two shortcodes in this plugin which I have already added

* **[service_pricing_table]** – to display list of courses on frontend any page or custom post
* **[online_form_course_fields course="field-id" type="field-id" price="field-id"]** – this something for out of this plugin, sometimes you have work with forms , so this is for getting yours courses and its pricing on [https://wordpress.org/plugins/visual-form-builder](Visual Form Builder) forms , you have to just pass field-ids in manner.

Take your time and perform all operations: _select, insert, update and delete_

## Customize the code

If yout take a look at the code you’ll see that every function has a prefix “**chints**” and the name of the table “**courses**“. This is because you need to create a namespace to avoid duplicated function names.

How to modify the code to manage another table:

*   **Replace** “chints” with your company name and “course” with the table name
*   Replace the columns ID and NAME with your columns
*   Modify the html forms

To learn how to use the wordpress database functions: [http://codex.wordpress.org/Class_Reference/wpdb](http://codex.wordpress.org/Class_Reference/wpdb)

The code is written with the minimum to avoid complexity.

Remember that the purpose of this code is to help you build your own plugin with validations, style, proper messages, etc.

All The Best !!
