<?php
/**
 * Template Name: מחשבון חיסכון
 */
defined('ABSPATH') || exit;
get_header();
?>
<main id="main" class="am-page">
  <div class="am-wrap">
    <div class="sav-app">
      <div class="app-shell">
        <div class="app-header">
          <h1>מחשבון חיסכון משפחתי ליעדים</h1>
          <p>תכנון חיסכון לפי יעדים עם הפקדה קבועה ודינמית. היעדים הראשונים הם דוגמה מהמחשבון המקורי, ואפשר למחוק או לשנות אותם.</p>
        </div>
        <div class="tab-bar">
          <button class="tab active" type="button" data-tab="0">הגדרות</button>
          <button class="tab" type="button" data-tab="1">סיכום</button>
          <button class="tab" type="button" data-tab="2">גרף</button>
          <button class="tab" type="button" data-tab="3">תזרים</button>
        </div>
        <div id="tab0">
          <div class="card">
            <p class="card-title">הנחות בסיס</p>
            <div class="field-group">
              <div class="field-row"><label for="startDate">תאריך התחלה</label><input type="date" id="startDate" value="2026-06-04"></div>
              <div class="field-row"><label for="initialBalance">יתרה התחלתית (₪)</label><input type="number" id="initialBalance" value="0" min="0"></div>
              <div class="field-row"><label for="annualReturn">תשואה שנתית (%)</label><input type="number" id="annualReturn" value="7" min="0" max="30" step="0.1"></div>
              <div class="field-row"><label>תשואה חודשית מחושבת</label><span id="monthlyReturnDisplay">—</span></div>
            </div>
            <div class="divider"></div>
            <div>
              <div class="deposit-note">הפקדה חודשית מומלצת</div>
              <div class="deposit-value" id="monthlyDepositDisplay">—</div>
              <div class="deposit-note">מחושב אוטומטית לפי היעדים הפעילים</div>
            </div>
          </div>
          <div class="card">
            <p class="card-title">יעדים משפחתיים</p>
            <div class="goals-table-wrap">
              <table class="goals-table">
                <thead>
                  <tr>
                    <th>פעיל</th><th>שם היעד</th><th>חודשים</th><th>תאריך</th><th>סכום (₪)</th><th>הערות</th><th></th>
                  </tr>
                </thead>
                <tbody id="goalsBody"></tbody>
              </table>
            </div>
            <button class="btn-add" id="addGoalBtn" type="button">+ הוסף יעד</button>
          </div>
        </div>
        <div id="tab1" style="display:none">
          <div id="alertBox"></div>
          <div class="metrics-grid">
            <div class="metric"><p class="metric-label">הפקדה חודשית</p><p class="metric-value ok" id="s-deposit">—</p></div>
            <div class="metric"><p class="metric-label">תשואה שנתית</p><p class="metric-value" id="s-return">—</p></div>
            <div class="metric"><p class="metric-label">יתרה מינימלית</p><p class="metric-value" id="s-min">—</p></div>
            <div class="metric"><p class="metric-label">יתרה בסוף</p><p class="metric-value" id="s-final">—</p></div>
            <div class="metric"><p class="metric-label">חודש ראשון שלילי</p><p class="metric-value ok" id="s-negmonth">אין</p></div>
          </div>
          <div class="two-col">
            <div class="card">
              <p class="card-title">הפקדה קבועה לכל התקופה</p>
              <div class="big-deposit">
                <div class="big-deposit-value" id="s-fixed-deposit">—</div>
                <div class="big-deposit-sub">הפקדה חודשית אחידה</div>
              </div>
            </div>
            <div class="card">
              <p class="card-title">חיסכון דינמי — אחרי כל יעד</p>
              <table class="data-table" id="dynamicTable">
                <thead><tr><th>שלב</th><th>לאחר יעד</th><th>הפקדה</th></tr></thead>
                <tbody id="dynamicBody"></tbody>
              </table>
            </div>
          </div>
          <div class="card">
            <p class="card-title">פירוט יעדים</p>
            <div style="overflow-x:auto">
              <table class="data-table">
                <thead>
                  <tr><th>יעד</th><th>תאריך</th><th>סכום</th><th>יתרה לפני (קבוע)</th><th>יתרה לפני (דינמי)</th><th>סטטוס</th></tr>
                </thead>
                <tbody id="summaryBody"></tbody>
              </table>
            </div>
          </div>
        </div>
        <div id="tab2" style="display:none">
          <div class="card">
            <p class="card-title">יתרה לאורך זמן</p>
            <div class="chart-wrap"><canvas id="balanceChart"></canvas></div>
          </div>
        </div>
        <div id="tab3" style="display:none">
          <div class="card">
            <p class="card-title">תזרים חודשי</p>
            <div class="scroll-table">
              <table class="flow-table">
                <thead>
                  <tr>
                    <th>חודש</th><th>תאריך</th><th>תשואה</th><th>הפקדה קבועה</th><th>משיכה</th><th>רווח</th><th>יתרה קבועה</th><th>הפקדה דינמית</th><th>יתרה דינמית</th><th>מינימום נדרש</th>
                  </tr>
                </thead>
                <tbody id="flowBody"></tbody>
              </table>
            </div>
          </div>
        </div>
        <p>תשואה של 7% היא הנחת פתיחה של המחשבון, לא הבטחה. להחלטה על הבית שלכם: <a href="<?php echo esc_url(home_url('/צור-קשר/')); ?>">לתיאום שיחת ייעוץ</a>.</p>
      </div>
    </div>
  </div>
</main>
<?php
get_footer();
