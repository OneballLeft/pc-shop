<?php
$page_title = 'Contact Us';
require_once 'includes/header.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validation
    if (empty($name)) {
        $errors[] = "Name is required";
    }

    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($subject)) {
        $errors[] = "Subject is required";
    }

    if (empty($message)) {
        $errors[] = "Message is required";
    }

    // Insert message if no errors
    if (empty($errors)) {
        $name_safe = mysqli_real_escape_string($conn, $name);
        $email_safe = mysqli_real_escape_string($conn, $email);
        $subject_safe = mysqli_real_escape_string($conn, $subject);
        $message_safe = mysqli_real_escape_string($conn, $message);

        $insert_query = "INSERT INTO contact_messages (name, email, subject, message)
                        VALUES ('$name_safe', '$email_safe', '$subject_safe', '$message_safe')";

        if (mysqli_query($conn, $insert_query)) {
            $success = true;
        } else {
            $errors[] = "Failed to send message. Please try again.";
        }
    }
}
?>

<div class="container">
    <h1 class="section-title">Contact Us</h1>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-top: 2rem;">
        <!-- Contact Form -->
        <div class="fade-in">
            <?php if ($success): ?>
                <div class="alert alert-success">
                    Thank you for your message! We'll get back to you soon.
                </div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!$success): ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" name="subject" value="<?php echo htmlspecialchars($_POST['subject'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label>Message</label>
                    <textarea name="message" required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                </div>

                <button type="submit" class="btn btn-secondary" style="width: 100%;">Send Message</button>
            </form>
            <?php endif; ?>
        </div>

        <!-- Contact Information -->
        <div class="fade-in">
            <div style="background: var(--bg-light); padding: 2rem; border-radius: 12px;">
                <h2 style="margin-bottom: 1.5rem;">Get in Touch</h2>
                <p style="margin-bottom: 2rem;">
                    Have a question about our products or services? We'd love to hear from you.
                    Fill out the form or reach us through the contact information below.
                </p>

                <div style="margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem;">Email</h3>
                    <p style="color: var(--text-light);">info@techpc.com</p>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem;">Phone</h3>
                    <p style="color: var(--text-light);">(555) 123-4567</p>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem;">Address</h3>
                    <p style="color: var(--text-light);">
                        123 Tech Street<br>
                        Silicon Valley, CA 94000
                    </p>
                </div>

                <div>
                    <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem;">Business Hours</h3>
                    <p style="color: var(--text-light);">
                        Monday - Friday: 9:00 AM - 6:00 PM<br>
                        Saturday: 10:00 AM - 4:00 PM<br>
                        Sunday: Closed
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media (max-width: 768px) {
    .container > div:first-of-type {
        grid-template-columns: 1fr !important;
    }
}
</style>

<?php require_once 'includes/footer.php'; ?>
