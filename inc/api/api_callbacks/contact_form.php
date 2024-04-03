<?php

function send_contact_form_email($request)
{
    // Retrieve input parameters
    $name = $request->get_param('name');
    $email = $request->get_param('email');
    $phone = $request->get_param('phone');
    $userMessage = $request->get_param('message');

    // Validate input
    $validationErrors = validate_contact_form_input($name, $email, $phone, $userMessage);

    // Check for validation errors
    if (!empty($validationErrors)) {
        return ['status' => 'error', 'message' => 'Some fields are missing or invalid', 'errors' => $validationErrors];
    }

    // Prepare and send the email
    $emailSent = send_email($name, $email, $phone, $userMessage);

    // Return the appropriate response based on email sending status
    if ($emailSent) {
        return ['status' => 'success', 'message' => 'Your message has been sent successfully.'];
    } else {
        return ['status' => 'error', 'message' => 'Failed to send your message. Please try again later.'];
    }
}

function validate_contact_form_input($name, $email, $phone, $message)
{
    $errors = [];
    if (empty($name)) {
        $errors['name'] = 'Name is required';
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
    if (empty($message)) {
        $errors['message'] = 'Message is required';
    }
    return $errors;
}

function send_email($name, $email, $phone, $message)
{
    $to = get_field('contact_form_email', 'option');
    $subject = "Contact Form Submission - " . get_bloginfo('name');
    $headers = ['Content-Type: text/html; charset=UTF-8'];

    $emailBody = "<html><body>";
    $emailBody .= "<h2>Contact Form Submission</h2>";
    $emailBody .= "<p><strong>Name:</strong> $name</p>";
    $emailBody .= "<p><strong>Email:</strong> $email</p>";
    $emailBody .= "<p><strong>Phone:</strong> $phone</p>";
    $emailBody .= "<p><strong>Message:</strong> $message</p>";
    $emailBody .= "</body></html>";

    return wp_mail($to, $subject, $emailBody, $headers);
}
