<?php
/**
 * Template Name: מחשבון תקציב
 */
defined('ABSPATH') || exit;
get_header();
$faq = [
    ['למה חשוב לנהל תקציב משפחתי?', 'ניהול תקציב משפחתי מסייע לשמור על יציבות כלכלית ולהבין לאן הכסף מופנה בכל חודש. הוא מאפשר לקבל החלטות כלכליות טובות יותר, להימנע מהוצאות מיותרות ולבנות בסיס יציב לעתיד.'],
    ['מדוע חשוב לעקוב אחר ההכנסות וההוצאות?', 'מעקב קבוע מספק תמונה ברורה של סכומי הכסף שנכנסים ויוצאים בכל חודש. כך ניתן לזהות פערים בתקציב ולבצע התאמות לפני שנוצרים קשיים כלכליים.'],
    ['כיצד ניהול תקציב מסייע להגדלת החיסכון?', 'ניהול תקציב מאפשר לזהות סעיפים שבהם ניתן לצמצם הוצאות ולחסוך כסף. גם שינויים קטנים בהרגלי הצריכה עשויים להצטבר לחיסכון משמעותי לאורך זמן.'],
    ['מה מלמד יחס ההוצאות להכנסות?', 'יחס ההוצאות להכנסות מציג איזה חלק מההכנסה החודשית מוקדש להוצאות שוטפות. כאשר היחס נמוך יותר, נותר מקום לחיסכון ולהיערכות כלכלית לטווח הארוך.'],
    ['כיצד ניתן לזהות גירעון בזמן?', 'כאשר ההוצאות עולות על ההכנסות נוצר גירעון חודשי שיש לטפל בו מוקדם ככל האפשר. זיהוי מוקדם מאפשר לבצע התאמות בתקציב לפני שהמצב מחמיר ומוביל לחובות.'],
    ['איך שימוש קבוע במחשבון התקציב מסייע להתנהלות הכלכלית?', 'עדכון הנתונים והשוואת התוצאות מדי חודש מאפשרים לזהות מגמות ושינויים בדפוסי הצריכה. כך ניתן לשמור על שליטה בתקציב, להגדיל את החיסכון ולחזק את הביטחון הכלכלי של המשפחה.'],
];
$schema = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => array_map(static function (array $row): array {
        return [
            '@type' => 'Question',
            'name' => $row[0],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $row[1]],
        ];
    }, $faq),
];
?>
<main id="main" class="am-page">
  <div class="am-wrap">
    <div class="fbc-outer">
      <h1 class="am-page-title">מחשבון תקציב משפחתי</h1>
      <p class="am-lead">הזינו הכנסות והוצאות לחישוב יתרת התקציב החודשי. ברירות המחדל הן דוגמה, לא ממוצע של לקוחות.</p>
      <div class="fbc-section">
        <div class="fbc-sec-title">הכנסות חודשיות</div>
        <div class="fbc-row"><label for="fbc-i1">משכורת נטו (בן/בת זוג 1)</label><input type="number" id="fbc-i1" value="10000" oninput="fbcCalc()"></div>
        <div class="fbc-row"><label for="fbc-i2">משכורת נטו (בן/בת זוג 2)</label><input type="number" id="fbc-i2" value="8000" oninput="fbcCalc()"></div>
        <div class="fbc-row"><label for="fbc-i3">הכנסות נוספות</label><input type="number" id="fbc-i3" value="0" oninput="fbcCalc()"></div>
      </div>
      <div class="fbc-section">
        <div class="fbc-sec-title">הוצאות קבועות</div>
        <div class="fbc-row"><label for="fbc-e1">שכר דירה / משכנתא</label><input type="number" id="fbc-e1" value="5000" oninput="fbcCalc()"></div>
        <div class="fbc-row"><label for="fbc-e2">ביטוחים</label><input type="number" id="fbc-e2" value="800" oninput="fbcCalc()"></div>
        <div class="fbc-row"><label for="fbc-e3">סלולרי, אינטרנט, כבלים</label><input type="number" id="fbc-e3" value="400" oninput="fbcCalc()"></div>
        <div class="fbc-row"><label for="fbc-e4">חינוך וגנים</label><input type="number" id="fbc-e4" value="1500" oninput="fbcCalc()"></div>
        <div class="fbc-row"><label for="fbc-e5">הלוואות / תשלומים</label><input type="number" id="fbc-e5" value="500" oninput="fbcCalc()"></div>
      </div>
      <div class="fbc-section">
        <div class="fbc-sec-title">הוצאות משתנות</div>
        <div class="fbc-row"><label for="fbc-v1">מזון וסופר</label><input type="number" id="fbc-v1" value="3000" oninput="fbcCalc()"></div>
        <div class="fbc-row"><label for="fbc-v2">תחבורה ודלק</label><input type="number" id="fbc-v2" value="800" oninput="fbcCalc()"></div>
        <div class="fbc-row"><label for="fbc-v3">בילויים ואירועים</label><input type="number" id="fbc-v3" value="500" oninput="fbcCalc()"></div>
        <div class="fbc-row"><label for="fbc-v4">ביגוד ורהיטים</label><input type="number" id="fbc-v4" value="300" oninput="fbcCalc()"></div>
        <div class="fbc-row"><label for="fbc-v5">הוצאות שונות</label><input type="number" id="fbc-v5" value="200" oninput="fbcCalc()"></div>
      </div>
      <div class="fbc-cards">
        <div class="fbc-card"><div class="lbl">סה״כ הכנסות</div><div class="val" id="fbc-total-in">₪18,000</div></div>
        <div class="fbc-card"><div class="lbl">סה״כ הוצאות</div><div class="val" id="fbc-total-out">₪13,000</div></div>
        <div class="fbc-card fbc-card-full">
          <div class="lbl">יתרה חודשית</div>
          <div class="val" id="fbc-balance">₪5,000</div>
          <div class="fbc-bar-wrap"><div class="fbc-bar" id="fbc-bar"></div></div>
          <p id="fbc-pct-lbl"></p>
          <p id="fbc-save-lbl"></p>
        </div>
      </div>
      <p>השלב הבא אחרי הטבלה: <a href="<?php echo esc_url(home_url('/ניהול-תקציב-משפחתי/')); ?>">איך מנהלים תקציב משפחתי</a> או <a href="<?php echo esc_url(home_url('/צור-קשר/')); ?>">שיחת ייעוץ</a>.</p>
      <h2>שאלות נפוצות</h2>
      <div class="am-faq">
        <?php foreach ($faq as $row) : ?>
          <details>
            <summary><?php echo esc_html($row[0]); ?></summary>
            <p><?php echo esc_html($row[1]); ?></p>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</main>
<script type="application/ld+json"><?php echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?></script>
<?php
get_footer();
