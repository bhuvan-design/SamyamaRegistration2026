<?php
session_start();
function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));

$activities = [
  'Kannada Singing', 'Solo Dance', 'Group Dance', 'Drama & Skits',
  'Kannada Poetry & Recitation', 'Kannada Quiz', 'Debate & Speech',
  'Rangoli Competition', 'Traditional Attire', 'Group Cultural Performance'
];
$types = ['Individual', 'Team'];
$data = ['name'=>'','usn'=>'','department'=>'','year'=>'','email'=>'','phone'=>'','type'=>'Individual','activity'=>[],'team_name'=>'','team_size'=>'','notes'=>'','declaration'=>''];
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  foreach (['name','usn','department','year','email','phone','type','team_name','team_size','notes','declaration'] as $k) {
    $data[$k] = trim($_POST[$k] ?? '');
  }
  $data['activity'] = $_POST['activity'] ?? [];
  if (!is_array($data['activity'])) $data['activity'] = [];

  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'] ?? '')) $errors[] = 'Session expired. Refresh the page and try again.';
  if (mb_strlen($data['name']) < 2) $errors[] = 'Enter your full name.';
  if ($data['usn'] === '') $errors[] = 'Enter your USN / student ID.';
  if ($data['department'] === '') $errors[] = 'Select your department.';
  if (!in_array($data['year'], ['1st Year','2nd Year','3rd Year','4th Year'], true)) $errors[] = 'Select your year of study.';
  if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email address.';
  if (!preg_match('/^[0-9+\-\s()]{8,16}$/', $data['phone'])) $errors[] = 'Enter a valid phone number.';
  if (!in_array($data['type'], $types, true)) $errors[] = 'Choose a participation type.';
  if (!$data['activity']) $errors[] = 'Select at least one activity.';
  foreach ($data['activity'] as $a) if (!in_array($a, $activities, true)) $errors[] = 'Invalid activity selection.';
  if ($data['type'] === 'Team') {
    if ($data['team_name'] === '') $errors[] = 'Enter your team name.';
    if (!ctype_digit($data['team_size']) || (int)$data['team_size'] < 2 || (int)$data['team_size'] > 30) $errors[] = 'Team size must be between 2 and 30.';
  }
  if ($data['declaration'] !== 'yes') $errors[] = 'Please confirm your details are correct.';

  if (!$errors) {
    $success = true;
    $reference = 'SAM26-' . strtoupper(bin2hex(random_bytes(3)));
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="SAMYAMA 2026 Kannada Rajyotsava cultural fest registration at RVITM">
<title>SAMYAMA 2026 | RVITM Cultural Fest</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Noto+Sans+Kannada:wght@400;500;600;700;800&family=Playfair+Display:wght@500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="top-stripe"><span></span><span></span></div>
<header class="nav">
<a class="college-brand" href="index.php">
    <img src="https://www.comedk.org/uploads/rvitmlogo.png" alt="RVITM Logo" class="college-logo">
    <span><b>RVITM</b><small>BHUVAN K PUJAR | 1RF25CS404</small></span>
</a>  <div class="nav-right"><span class="nav-dot"></span> CULTURAL FEST · 2026</div>
</header>
<main>
<?php if ($success): ?>
<section class="confirmation">
  <div class="confirm-top"><span class="kannada">ನೋಂದಣಿ ಯಶಸ್ವಿಯಾಗಿದೆ</span><span class="success-tick">✓</span></div>
  <p class="kicker">SAMYAMA 2026 · REGISTRATION CONFIRMED</p>
  <h1>ನಿಮ್ಮ ಸಂಭ್ರಮಕ್ಕೆ<br><em>ಸ್ವಾಗತ!</em></h1>
  <p class="confirm-copy">Thank you, <?= e($data['name']) ?>! Your registration for SAMYAMA, RVITM's Kannada Rajyotsava cultural celebration, has been received.</p>
  <div class="ref-card"><span>YOUR REGISTRATION ID</span><strong><?= e($reference) ?></strong></div>
  <div class="section-title"><span>01</span><h2>Participant details</h2><i></i></div>
  <div class="summary">
    <div><small>NAME</small><b><?= e($data['name']) ?></b></div>
    <div><small>USN / STUDENT ID</small><b><?= e($data['usn']) ?></b></div>
    <div><small>DEPARTMENT</small><b><?= e($data['department']) ?></b></div>
    <div><small>YEAR</small><b><?= e($data['year']) ?></b></div>
    <div><small>EMAIL</small><b><?= e($data['email']) ?></b></div>
    <div><small>PHONE</small><b><?= e($data['phone']) ?></b></div>
    <div><small>PARTICIPATION</small><b><?= e($data['type']) ?></b></div>
    <?php if ($data['type']==='Team'): ?><div><small>TEAM</small><b><?= e($data['team_name']) ?> · <?= e($data['team_size']) ?> members</b></div><?php endif; ?>
    <div class="wide"><small>SELECTED ACTIVITIES</small><b><?= e(implode(' · ', $data['activity'])) ?></b></div>
    <?php if ($data['notes']!==''): ?><div class="wide"><small>ADDITIONAL NOTES</small><b><?= nl2br(e($data['notes'])) ?></b></div><?php endif; ?>
  </div>
  <div class="confirm-actions"><p>ಕನ್ನಡವೇ ಸತ್ಯ, ಕನ್ನಡವೇ ನಿತ್ಯ ❤️💛<br><small>Keep your registration ID for event-day verification.</small></p><button class="btn btn-red" onclick="window.print()">Print confirmation <span>↗</span></button></div>
  <a class="back-link" href="index.php">← Back to SAMYAMA portal</a>
</section>
<?php else: ?>
<section class="hero">
  <div class="hero-copy">
    <p class="kicker"><span class="kicker-line"></span> RVITM PRESENTS · KANNADA RAJYOTSAVA</p>
    <h1 class="kannada-title">ಸಂಯಮ</h1>
    <h2 class="hero-name">SAMYAMA<span class="hero-star">✦</span></h2>
    <div class="flag-rule"><span></span><span></span></div>
    <p class="hero-sub">ಕನ್ನಡದ ಕಲೆ, ಸಂಸ್ಕೃತಿ ಮತ್ತು ಸಡಗರದ ಹಬ್ಬ.</p>
    <p class="hero-description">A celebration of our language, heritage, talent and togetherness. Step forward, take the stage and be part of the colours of Karnataka.</p>
    <div class="hero-tags"><span>ಕನ್ನಡ · CULTURE</span><span>ART · TALENT</span><span>TOGETHERNESS</span></div>
  </div>
  <div class="hero-art" aria-label="Kannada Rajyotsava celebration artwork">
    <div class="art-ring ring-one"></div><div class="art-ring ring-two"></div>
    <div class="art-sun">✦</div>
    <div class="art-center"><span class="art-kannada">ಕನ್ನಡ</span><strong>ನಮ್ಮ<br>ಹೆಮ್ಮೆ</strong><small>OUR PRIDE · OUR ROOTS</small></div>
    <div class="art-side art-left">ಸಂಸ್ಕೃತಿ</div><div class="art-side art-right">ಸಂಭ್ರಮ</div>
    <div class="art-bottom">RVITM · BENGALURU</div>
  </div>
  <div class="hero-bottom"><span>01 / CELEBRATE OUR ROOTS</span><span>SCROLL TO REGISTER ↓</span></div>
</section>

<section class="form-section" id="register">
  <div class="form-intro"><div><p class="kicker">BE PART OF THE CELEBRATION</p><h2>Take the stage.<br><em>Make it yours.</em></h2></div><p>Fill in your details and choose the activities you would love to participate in. Let's make this Rajyotsava unforgettable.</p></div>
  <div class="form-card">
    <div class="form-heading"><div><span class="kicker">SAMYAMA 2026 / PARTICIPANT ENTRY</span><h3>Event registration</h3><p>All fields marked <b>*</b> are required.</p></div><div class="form-number">01<small> / 01</small></div></div>
    <?php if ($errors): ?><div class="error-box" role="alert"><b>Please check the following:</b><ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
    <form id="eventForm" method="POST" action="index.php" novalidate>
      <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
      <div class="section-title"><span>01</span><h2>Who are you?</h2><i></i></div>
      <div class="grid">
        <div class="field full"><label for="name">Full name <b>*</b></label><input id="name" name="name" value="<?= e($data['name']) ?>" placeholder="Enter your name as per college records" required><small class="field-error"></small></div>
        <div class="field"><label for="usn">USN / Student ID <b>*</b></label><input id="usn" name="usn" value="<?= e($data['usn']) ?>" placeholder="e.g. 1RV23CS001" required><small class="field-error"></small></div>
        <div class="field"><label for="department">Department <b>*</b></label><select id="department" name="department" required><option value="">Select department</option><?php foreach (['Computer Science & Engineering','Information Science & Engineering','Artificial Intelligence & Machine Learning','Electronics & Communication Engineering','Other'] as $d): ?><option <?= $data['department']===$d?'selected':'' ?>><?= e($d) ?></option><?php endforeach; ?></select><small class="field-error"></small></div>
        <div class="field"><label for="year">Year of study <b>*</b></label><select id="year" name="year" required><option value="">Select year</option><?php foreach (['1st Year','2nd Year','3rd Year','4th Year'] as $y): ?><option <?= $data['year']===$y?'selected':'' ?>><?= e($y) ?></option><?php endforeach; ?></select><small class="field-error"></small></div>
        <div class="field"><label for="email">College / personal email <b>*</b></label><input type="email" id="email" name="email" value="<?= e($data['email']) ?>" placeholder="name@example.com" required><small class="field-error"></small></div>
        <div class="field"><label for="phone">Contact number <b>*</b></label><input type="tel" id="phone" name="phone" value="<?= e($data['phone']) ?>" placeholder="+91 98765 43210" required><small class="field-error"></small></div>
      </div>

      <div class="section-title section-space"><span>02</span><h2>How will you participate?</h2><i></i></div>
      <div class="participation-options">
        <label class="choice-card"><input type="radio" name="type" value="Individual" <?= $data['type']==='Individual'?'checked':'' ?>><span class="choice-icon">✦</span><span><b>Individual</b><small>I'm performing solo</small></span><span class="choice-radio"></span></label>
        <label class="choice-card"><input type="radio" name="type" value="Team" <?= $data['type']==='Team'?'checked':'' ?>><span class="choice-icon">♧</span><span><b>Team</b><small>We're performing together</small></span><span class="choice-radio"></span></label>
      </div>
      <div class="grid team-fields" id="teamFields" style="display:none">
        <div class="field"><label for="team_name">Team name <b>*</b></label><input id="team_name" name="team_name" value="<?= e($data['team_name']) ?>" placeholder="Your team name"></div>
        <div class="field"><label for="team_size">Number of members <b>*</b></label><input id="team_size" name="team_size" type="number" min="2" max="30" value="<?= e($data['team_size']) ?>" placeholder="2–30"></div>
      </div>

      <div class="section-title section-space"><span>03</span><h2>Choose your activities</h2><i></i></div>
      <p class="section-hint">Select one or more activities you wish to participate in.</p>
      <div class="activity-grid">
        <?php $icons=['♫','✧','♬','✺','ಕ','?','◈','❋','✦','♧']; foreach ($activities as $i=>$a): ?>
        <label class="activity-option"><input type="checkbox" name="activity[]" value="<?= e($a) ?>" <?= in_array($a,$data['activity'],true)?'checked':'' ?>><span class="activity-check">✓</span><span class="activity-icon"><?= $icons[$i] ?></span><b><?= e($a) ?></b></label>
        <?php endforeach; ?>
      </div>
      <div class="field notes-field"><label for="notes">Anything else you'd like us to know? <span>OPTIONAL</span></label><textarea id="notes" name="notes" rows="3" maxlength="400" placeholder="Special requirements, performance details, or a short note..."><?= e($data['notes']) ?></textarea></div>
      <div class="declaration"><label class="check-wrap"><input type="checkbox" name="declaration" value="yes" <?= $data['declaration']==='yes'?'checked':'' ?>><span class="fake-check"></span><span>I confirm that the details provided are correct and agree to follow the event guidelines. <b>*</b></span></label><small id="declarationError" class="field-error"></small></div>
      <div class="submit-row"><p><span>❤️💛</span> ಕನ್ನಡದ ಸಂಭ್ರಮದಲ್ಲಿ ಭೇಟಿಯಾಗೋಣ!</p><button class="btn btn-red" type="submit">Complete registration <span>↗</span></button></div>
    </form>
  </div>
</section>
<footer class="footer"><div class="footer-brand"><img src="https://www.comedk.org/uploads/rvitmlogo.png" alt="RVITM Logo" class="college-logo"><span><b>RVITM</b><small>R V INSTITUTE OF TECHNOLOGY AND MANAGEMENT</small></span></div><p>ಕರ್ನಾಟಕದಲ್ಲಿ ಕನ್ನಡಿಗನೇ ಸಾರ್ವಭೌಮ</p><span class="footer-copy">BHUVAN K PUJAR | 1RF25CS404</span></footer>
<?php endif; ?>
</main>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
