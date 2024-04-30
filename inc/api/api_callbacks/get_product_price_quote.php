<?php
function get_product_price_quote($request)
{
    $full_name = $request->get_param('full_name');
    $email = $request->get_param('email');
    $phone = $request->get_param('phone');
    $product_id = $request->get_param('product_id');

    $validationErrors = validate_quote_form_input($full_name, $email, $phone, $product_id);

    if (!empty($validationErrors)) {
        return ['status' => 'error', 'message' => 'Some fields are missing or invalid', 'errors' => $validationErrors];
    }

    $emailSent = send_quote_email($full_name, $email, $phone, $product_id);

    // Return the appropriate response based on email sending status
    if ($emailSent) {
        return ['status' => 'success', 'message' => 'Your price quote request has been sent successfully.'];
    } else {
        return ['status' => 'error', 'message' => 'Failed to send your price quote request. Please try again later.'];
    }
}


function validate_quote_form_input($full_name, $email, $phone, $product_id)
{
    $errors = [];
    if (empty($full_name)) {
        $errors['full_name'] = 'Full Name is required';
    }
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }
    if (empty($phone)) {
        $errors['phone'] = 'Phone is required';
    } else if (!preg_match('/^\+?\d+$/', $phone)) {
        $errors['phone'] = 'Invalid phone number format';
    }
    if (empty($product_id)) {
        $errors['product_id'] = 'Product ID is required';
    }
    // Check if the product exists
    if (!get_post($product_id)) {
        $errors['product_id'] = 'Product does not exist';
    }
    return $errors;
}

function send_quote_email($full_name, $email, $phone, $product_id)
{
    $to = get_field('contact_form_email', 'option');
    $subject = "Price Quote Request - " . get_bloginfo('name');
    $headers = ['Content-Type: text/html; charset=UTF-8'];

    $emailBody = "<html><body>";
    $emailBody .= "<h2>Price Quote Request</h2>";
    $emailBody .= "<p><strong>Full Name:</strong> $full_name</p>";
    $emailBody .= "<p><strong>Email:</strong> $email</p>";
    $emailBody .= "<p><strong>Phone:</strong> $phone</p>";
    $emailBody .= "<p><strong>Product ID:</strong> $product_id</p>";
    $emailBody .= "<p><strong>Product Name:</strong>" . get_the_title($product_id) . "</p>";
    $emailBody .= "<p><strong>Product URL:</strong>" . get_the_permalink($product_id) . "</p>";
    $emailBody .= "</body></html>";


    return wp_mail($to, $subject, $emailBody, $headers);
}
