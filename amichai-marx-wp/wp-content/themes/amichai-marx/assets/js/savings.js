
const fmt    = v => '₪' + Math.round(v).toLocaleString('he-IL');
const fmtPct = v => (v * 100).toFixed(4) + '%';
const fmtD   = d => new Date(d).toLocaleDateString('he-IL', {year:'numeric', month:'2-digit'});

const defaultGoals = [
  {name:'בת מצווה קשת', months:12,  amount:18000,  notes:'דוגמה - ניתן למחוק/לשנות', active:true},
  {name:'בר מצווה ברק', months:78,  amount:18000,  notes:'דוגמה', active:true},
  {name:'בר מצווה טל',  months:98,  amount:18000,  notes:'דוגמה', active:true},
  {name:'בת מצווה רוח', months:144, amount:18000,  notes:'', active:true},
  {name:'חתונה רעם',    months:156, amount:100000, notes:'', active:true},
  {name:'חתונה קשת',    months:222, amount:100000, notes:'', active:true},
  {name:'חתונה ברק',    months:242, amount:100000, notes:'', active:true},
  {name:'חתונה טל',     months:288, amount:100000, notes:'', active:true},
  {name:'חתונה רוח',    months:300, amount:100000, notes:'', active:true},
];

let goals = JSON.parse(JSON.stringify(defaultGoals));
let chartInst = null;

function activeGoals() { return goals.filter(g => g.active); }

function addDate(start, months) {
  const d = new Date(start);
  d.setMonth(d.getMonth() + months);
  return d;
}

function renderGoalsTable() {
  const tbody = document.getElementById('goalsBody');
  tbody.innerHTML = '';
  const startDate = new Date(document.getElementById('startDate').value);
  goals.forEach((g, i) => {
    const tr = document.createElement('tr');
    if (!g.active) tr.classList.add('inactive-row');
    const targetDate = addDate(startDate, g.months);
    tr.innerHTML =
      `<td style="text-align:center">
         <button class="toggle ${g.active ? 'on' : 'off'}" onclick="goals[${i}].active=!goals[${i}].active;renderGoalsTable();recalc()"></button>
       </td>
       <td><input class="cell-input" type="text" style="min-width:110px" value="${g.name.replace(/"/g,'&quot;')}" onchange="goals[${i}].name=this.value;renderGoalsTable();recalc()"></td>
       <td><input class="cell-input" type="number" style="width:62px" value="${g.months}" onchange="goals[${i}].months=+this.value;renderGoalsTable();recalc()"></td>
       <td style="font-size:11px;color:var(--ink-dim)">${fmtD(targetDate)}</td>
       <td><input class="cell-input" type="number" style="width:90px" value="${g.amount}" onchange="goals[${i}].amount=+this.value;recalc()"></td>
       <td><input class="cell-input" type="text" style="min-width:80px" value="${g.notes.replace(/"/g,'&quot;')}" onchange="goals[${i}].notes=this.value"></td>
       <td><button class="btn-del" onclick="goals.splice(${i},1);renderGoalsTable();recalc()">✕</button></td>`;
    tbody.appendChild(tr);
  });
}

document.getElementById('addGoalBtn').addEventListener('click', () => {
  goals.push({name:'יעד חדש', months:12, amount:10000, notes:'', active:true});
  renderGoalsTable();
  recalc();
});

function getInputs() {
  return {
    startDate: new Date(document.getElementById('startDate').value),
    init:      +document.getElementById('initialBalance').value || 0,
    annualR:   (+document.getElementById('annualReturn').value || 7) / 100,
  };
}

function monthlyRate(annualR) { return Math.pow(1 + annualR, 1/12) - 1; }

function buildGoalMap() {
  const gm = {};
  activeGoals().forEach(g => { gm[g.months] = (gm[g.months] || 0) + g.amount; });
  return gm;
}

function maxMonth() {
  const ag = activeGoals();
  return ag.length === 0 ? 360 : Math.max(360, ...ag.map(g => g.months + 12));
}

function calcOptimalDeposit(init, annualR) {
  if (activeGoals().length === 0) return 0;
  const mr = monthlyRate(annualR);
  const gm = buildGoalMap();
  const mx = maxMonth();
  function minBal(monthly) {
    let bal = init, min = Infinity;
    for (let m = 1; m <= mx; m++) {
      bal = bal * (1 + mr) + monthly - (gm[m] || 0);
      if (bal < min) min = bal;
    }
    return min;
  }
  const totalGoals = activeGoals().reduce((s,g) => s + g.amount, 0);
  let lo = 0, hi = totalGoals;
  for (let i = 0; i < 80; i++) {
    const mid = (lo + hi) / 2;
    if (minBal(mid) < 0) lo = mid; else hi = mid;
  }
  return Math.ceil(hi);
}

function buildFlow(fixed, init, annualR) {
  const mr = monthlyRate(annualR);
  const gm = buildGoalMap();
  const mx = maxMonth();
  const ag = activeGoals().sort((a,b) => a.months - b.months);
  const milestones = [...new Set(ag.map(g => g.months))].sort((a,b) => a-b);

  function minDepositFrom(startBal, startM) {
    function minB(dep) {
      let bal = startBal, min = Infinity;
      for (let m = startM + 1; m <= mx; m++) {
        bal = bal * (1 + mr) + dep - (gm[m] || 0);
        if (bal < min) min = bal;
      }
      return min;
    }
    const remaining = activeGoals().reduce((s,g) => g.months > startM ? s + g.amount : s, 0);
    if (remaining === 0) return 0;
    let lo = 0, hi = remaining;
    for (let i = 0; i < 80; i++) {
      const mid = (lo + hi) / 2;
      if (minB(mid) < 0) lo = mid; else hi = mid;
    }
    return Math.ceil(hi);
  }

  function minDepositNeeded(currentBal, currentM) {
    function minB(dep) {
      let bal = currentBal, min = Infinity;
      for (let m = currentM; m <= mx; m++) {
        bal = bal * (1 + mr) + dep - (gm[m] || 0);
        if (bal < min) min = bal;
      }
      return min;
    }
    const remaining = activeGoals().reduce((s,g) => g.months >= currentM ? s + g.amount : s, 0);
    if (remaining === 0) return 0;
    let lo = 0, hi = remaining;
    for (let i = 0; i < 80; i++) {
      const mid = (lo + hi) / 2;
      if (minB(mid) < 0) lo = mid; else hi = mid;
    }
    return Math.ceil(hi);
  }

  const rows = [];
  let balFixed = init, balDyn = init, dynDep = fixed;

  for (let m = 1; m <= mx; m++) {
    const withdrawal = gm[m] || 0;
    if (milestones.includes(m - 1) && m > 1) {
      dynDep = minDepositFrom(balDyn, m - 1);
    }
    const profitFixed = balFixed * mr;
    const closeFixed  = balFixed + fixed + profitFixed - withdrawal;
    const profitDyn   = balDyn * mr;
    const closeDyn    = balDyn + dynDep + profitDyn - withdrawal;
    const minNeeded   = (withdrawal > 0 || m % 12 === 0) ? minDepositNeeded(balFixed, m) : null;

    rows.push({ m, withdrawal, profitFixed, closeFixed, dynDep, profitDyn, closeDyn, minNeeded, isGoalMonth: withdrawal > 0 });
    balFixed = closeFixed;
    balDyn   = closeDyn;
    if (milestones.includes(m)) { dynDep = minDepositFrom(balDyn, m); }
  }
  return rows;
}

function recalc() {
  const inp = getInputs();
  const mr  = monthlyRate(inp.annualR);
  document.getElementById('monthlyReturnDisplay').textContent = fmtPct(mr);
  const fixed = calcOptimalDeposit(inp.init, inp.annualR);
  document.getElementById('monthlyDepositDisplay').textContent = fmt(fixed);
  const rows = buildFlow(fixed, inp.init, inp.annualR);
  updateSummary(fixed, inp, rows, mr);
  updateChart(rows, fixed);
  updateFlow(rows, fixed, mr, inp.startDate);
}

function updateSummary(fixed, inp, rows, mr) {
  const minBal   = Math.min(...rows.map(r => r.closeFixed));
  const finalBal = rows[rows.length - 1].closeFixed;
  const negRow   = rows.find(r => r.closeFixed < 0);
  const ag       = activeGoals().sort((a,b) => a.months - b.months);

  document.getElementById('s-deposit').textContent = fmt(fixed);
  document.getElementById('s-return').textContent  = (inp.annualR * 100).toFixed(1) + '%';

  const minEl = document.getElementById('s-min');
  minEl.textContent = fmt(minBal);
  minEl.className = 'metric-value ' + (minBal < 0 ? 'bad' : minBal < 500 ? 'warn' : 'ok');

  document.getElementById('s-final').textContent = fmt(finalBal);
  document.getElementById('s-fixed-deposit').textContent = fmt(fixed);

  const negEl = document.getElementById('s-negmonth');
  if (negRow) {
    negEl.textContent = `חודש ${negRow.m}`;
    negEl.className = 'metric-value bad';
  } else {
    negEl.textContent = 'אין';
    negEl.className = 'metric-value ok';
  }

  document.getElementById('alertBox').innerHTML = negRow
    ? `<div class="alert bad">⚠️ יתרה שלילית מתחילה בחודש ${negRow.m} (${fmtD(addDate(inp.startDate, negRow.m))}) — שקול להגדיל הפקדה</div>`
    : `<div class="alert ok">✓ כל היעדים ממומנים — הפקדה חודשית מומלצת ${fmt(fixed)}</div>`;

  // Dynamic steps
  const dynBody = document.getElementById('dynamicBody');
  dynBody.innerHTML = '';
  let lastDep = fixed;
  const steps = [{afterMonth: 0, label: 'התחלה', deposit: fixed}];
  rows.forEach(r => {
    if (r.isGoalMonth && r.dynDep !== lastDep) {
      const goalNames = ag.filter(g => g.months === r.m).map(g => g.name).join(', ');
      steps.push({afterMonth: r.m, label: goalNames, deposit: r.dynDep});
      lastDep = r.dynDep;
    }
  });
  steps.forEach((s, i) => {
    const tr = document.createElement('tr');
    const diff = i === 0 ? '' : (s.deposit < steps[i-1].deposit
      ? `<span style="color:var(--green);font-size:10px"> ↓ ${fmt(steps[i-1].deposit - s.deposit)}</span>`
      : `<span style="color:var(--amber);font-size:10px"> ↑ ${fmt(s.deposit - steps[i-1].deposit)}</span>`);
    tr.innerHTML = `<td>${i === 0 ? 'ראשוני' : `אחרי ${s.afterMonth}`}</td><td style="font-size:11px;color:var(--ink-dim)">${s.label}</td><td>${fmt(s.deposit)}${diff}</td>`;
    dynBody.appendChild(tr);
  });

  // Goals detail
  const tbody = document.getElementById('summaryBody');
  tbody.innerHTML = '';
  ag.forEach(g => {
    const row = rows[g.months - 1];
    const openFixed = row ? (row.closeFixed - fixed - row.profitFixed + row.withdrawal) : 0;
    const openDyn   = row ? (row.closeDyn - row.dynDep - row.profitDyn + row.withdrawal) : 0;
    const ok = openFixed >= g.amount;
    const tr = document.createElement('tr');
    tr.innerHTML =
      `<td>${g.name}</td>` +
      `<td>${fmtD(addDate(inp.startDate, g.months))}</td>` +
      `<td>${fmt(g.amount)}</td>` +
      `<td>${fmt(openFixed)}</td>` +
      `<td>${fmt(openDyn)}</td>` +
      `<td><span class="badge ${ok ? 'ok' : 'bad'}">${ok ? '✓ מכוסה' : '✗ חסר'}</span></td>`;
    tbody.appendChild(tr);
  });
}

function updateChart(rows, fixed) {
  if (chartInst) { chartInst.destroy(); chartInst = null; }
  chartInst = new Chart(document.getElementById('balanceChart'), {
    type: 'line',
    data: {
      labels: rows.map(r => r.m),
      datasets: [
        {
          label: 'הפקדה קבועה',
          data: rows.map(r => Math.round(r.closeFixed)),
          borderColor: '#1D9E75',
          backgroundColor: 'rgba(29,158,117,0.07)',
          borderWidth: 1.5, fill: true, tension: 0.3, pointRadius: 0,
        },
        {
          label: 'חיסכון דינמי',
          data: rows.map(r => Math.round(r.closeDyn)),
          borderColor: '#BA7517',
          backgroundColor: 'rgba(186,117,23,0.04)',
          borderWidth: 1.5, fill: false, tension: 0.3, pointRadius: 0,
          borderDash: [4, 3],
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      interaction: { mode: 'index', intersect: false },
      plugins: {
        legend: { position: 'top', align: 'start', labels: { boxWidth: 10, font: { size: 11 } } },
        tooltip: { callbacks: { label: ctx => ctx.dataset.label + ': ₪' + ctx.raw.toLocaleString('he-IL') } }
      },
      scales: {
        x: {
          ticks: { maxTicksLimit: 10, color: '#888780', font: { size: 10 },
            callback: (v, i) => i % 12 === 0 ? `${rows[i]?.m}` : '' },
          grid: { color: 'rgba(136,135,128,0.1)' }
        },
        y: {
          ticks: { color: '#888780', font: { size: 10 }, callback: v => '₪' + (v/1000).toFixed(0) + 'K' },
          grid: { color: 'rgba(136,135,128,0.1)' }
        }
      }
    }
  });
}

function updateFlow(rows, fixed, mr, startDate) {
  const tbody = document.getElementById('flowBody');
  tbody.innerHTML = '';
  rows.slice(0, 360).forEach(r => {
    const tr = document.createElement('tr');
    if (r.isGoalMonth) tr.classList.add('flow-goal');
    tr.innerHTML =
      `<td>${r.m}</td>` +
      `<td>${fmtD(addDate(startDate, r.m))}</td>` +
      `<td class="dim">${fmtPct(mr)}</td>` +
      `<td>${fmt(fixed)}</td>` +
      `<td>${r.withdrawal > 0 ? fmt(r.withdrawal) : '—'}</td>` +
      `<td class="dim">${fmt(r.profitFixed)}</td>` +
      `<td class="${r.closeFixed < 0 ? 'neg' : ''}">${fmt(r.closeFixed)}</td>` +
      `<td class="${r.dynDep !== fixed ? 'dyn-changed' : ''}">${fmt(r.dynDep)}</td>` +
      `<td class="${r.closeDyn < 0 ? 'neg' : ''}">${fmt(r.closeDyn)}</td>` +
      `<td class="dim">${r.minNeeded !== null ? fmt(r.minNeeded) : '—'}</td>`;
    tbody.appendChild(tr);
  });
}

// Tab switching
document.querySelectorAll('.tab').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const i = btn.dataset.tab;
    ['tab0','tab1','tab2','tab3'].forEach((id, j) => {
      document.getElementById(id).style.display = j == i ? '' : 'none';
    });
    if (i == '2') recalc();
  });
});

['startDate','initialBalance','annualReturn'].forEach(id => {
  document.getElementById(id).addEventListener('change', () => { renderGoalsTable(); recalc(); });
});

renderGoalsTable();
recalc();
