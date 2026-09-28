(() => {
  const $ = s => document.querySelector(s), esc = BinaLib.escapeHtml;
  const settings = () => BinaLib.getSettings();
  function applySystemSettings(){ const s=settings(); const label=document.getElementById('libraryNameLabel'); if(label) label.textContent=s.libraryName; updateLimitLabels(); }
  let mode = null, member = null, selectedBookId = null, selectedQty = 0, loanType = 'pribadi', returnSelection = [];

  const maxQty = () => { const s=BinaLib.getSettings(); return loanType === 'kelas' ? s.maxClassCopies : s.maxPersonalCopies; };
  const activeBook = () => selectedBookId == null ? null : BinaLib.book(selectedBookId);
  const coverFallback = title => `<div class="generated-cover"><b>${esc(title)}</b><span>Koleksi ${esc(settings().libraryName)}</span></div>`;
  const bookCover = b => { const src=b.imageData||b.image||''; return src ? `<img src="${esc(src)}" alt="${esc(b.title)}">` : coverFallback(b.title); };

  function resetSelection(){ selectedBookId=null; selectedQty=0; }
  function showStart(){
    mode=null; member=null; resetSelection(); returnSelection=[];
    $('#startScreen').classList.remove('hidden'); $('#serviceScreen').classList.add('hidden');
    $('#scanCard').classList.remove('hidden'); $('#memberSection').classList.add('hidden');
    $('#borrowContent').classList.add('hidden'); $('#returnContent').classList.add('hidden');
    $('#rfidInput').value=''; $('#rfidWarning').classList.add('hidden');
  }
  function chooseMode(m){
    mode=m; member=null; resetSelection(); returnSelection=[];
    $('#startScreen').classList.add('hidden'); $('#serviceScreen').classList.remove('hidden');
    $('#scanCard').classList.remove('hidden'); $('#memberSection').classList.add('hidden');
    $('#borrowContent').classList.add('hidden'); $('#returnContent').classList.add('hidden');
    $('#serviceEyebrow').textContent=m==='borrow'?'PEMINJAMAN':'PENGEMBALIAN';
    $('#rfidInput').value=''; $('#rfidWarning').classList.add('hidden');
    setTimeout(()=>$('#rfidInput').focus(),80);
  }
  function setMember(s){
    $('#memberName').textContent=s.name||'-'; $('#memberNis').textContent=s.nis||'-'; $('#memberClass').textContent=s.class||'-'; $('#memberId').textContent=s.libraryId||'-';
    $('#memberSection').classList.remove('hidden');
  }
  function scan(){
    const uid=$('#rfidInput').value.trim();
    if(!uid) return BinaLib.saveToast('Tap atau masukkan UID RFID terlebih dahulu.');
    const s=BinaLib.findStudentRFID(uid); member=s||null;
    if(!s){
      $('#memberSection').classList.add('hidden'); $('#borrowContent').classList.add('hidden'); $('#returnContent').classList.add('hidden');
      $('#rfidWarning').classList.remove('hidden');
      $('#rfidWarning').textContent='Kartu RFID belum terdaftar di database BinaLib. Silakan lakukan registrasi terlebih dahulu melalui Admin.';
      return;
    }
    $('#rfidWarning').classList.add('hidden');
    // Once identified, the RFID input/scan area disappears.
    $('#scanCard').classList.add('hidden');
    setMember(s);
    if(mode==='borrow'){
      $('#borrowContent').classList.remove('hidden'); $('#returnContent').classList.add('hidden');
      resetSelection(); loanType='pribadi'; updateLimitLabels(); setLoanType('pribadi'); renderCatalog(); renderSummary();
    } else {
      $('#returnContent').classList.remove('hidden'); $('#borrowContent').classList.add('hidden');
      renderReturns();
    }
  }

  function renderCatalog(){
    const q=($('#bookSearch').value||'').trim().toLowerCase();
    const books=BinaLib.get('books').filter(b=>[b.code,b.title,b.author].some(v=>String(v||'').toLowerCase().includes(q)));
    $('#catalog').innerHTML=books.length?books.map(b=>{
      const chosen=Number(selectedBookId)===Number(b.id), stock=Number(b.stock||0);
      return `<article class="book-card ${chosen?'selected':''}"><div class="book-cover">${bookCover(b)}</div><div class="book-body"><h3>${esc(b.title)}</h3><p>${esc(b.author||'-')} • ${esc(b.code||'')}</p><div class="stock-row"><span class="stock">${stock} eksemplar tersedia</span><span class="badge ${stock?'badge-green':'badge-red'}">${stock?'Tersedia':'Habis'}</span></div><div class="book-actions"><button class="select-book ${chosen?'active':''}" data-select="${b.id}" ${!stock?'disabled':''}>${chosen?'Buku Dipilih':'Pilih Buku'}</button></div></div></article>`
    }).join(''):'<div class="empty" style="grid-column:1/-1">Belum ada data buku.</div>';
    $('#catalog').querySelectorAll('[data-select]').forEach(btn=>btn.onclick=()=>selectBook(Number(btn.dataset.select)));
  }
  function updateLimitLabels(){
    const s=BinaLib.getSettings();
    const p=document.getElementById('personalLimitLabel'), c=document.getElementById('classLimitLabel');
    if(p) p.textContent=`maks. ${s.maxPersonalCopies} eksemplar`;
    if(c) c.textContent=`maks. ${s.maxClassCopies} eksemplar`;
  }

  function setLoanType(type){
    updateLimitLabels();
    loanType=type;
    document.querySelectorAll('[data-loan-type]').forEach(btn=>btn.classList.toggle('active',btn.dataset.loanType===type));
    if(selectedQty>maxQty()) selectedQty=maxQty();
    renderSummary();
  }
  function selectBook(id){
    if(!member)return;
    // Exactly one title per borrowing transaction.
    if(selectedBookId!==null && Number(selectedBookId)!==Number(id)) return BinaLib.saveToast('Peminjaman hanya boleh memilih 1 judul buku. Hapus pilihan sebelumnya jika ingin mengganti buku.');
    const b=BinaLib.book(id); if(!b||Number(b.stock)<=0)return;
    selectedBookId=id; selectedQty=1; renderCatalog(); renderSummary();
  }
  function changeQty(delta){
    const b=activeBook(); if(!b)return;
    const next=Math.max(1,Math.min(Number(b.stock)||1,Math.min(maxQty(),selectedQty+delta)));
    selectedQty=next; renderSummary();
  }
  function renderSummary(){
    const b=activeBook(), max=maxQty();
    $('#totalQty').textContent=`${b?selectedQty:0} / ${max}`;
    if(!b){
      $('#borrowSummary').innerHTML='<div class="empty">Belum ada buku yang dipilih.</div>';
      $('#quantityBox').classList.add('hidden'); $('#confirmBorrow').disabled=true; return;
    }
    $('#borrowSummary').innerHTML=`<div class="summary-item"><div><strong>${esc(b.title)}</strong><small>${esc(b.code||'')} • ${esc(b.author||'-')}</small><span class="summary-type">${loanType==='kelas'?'Kegunaan Kelas':'Penggunaan Pribadi'}</span></div><button class="remove-book" id="removeBook">Hapus</button></div>`;
    $('#quantityBox').classList.remove('hidden'); $('#quantityLabel').textContent=`${selectedQty} / ${max}`; const qi=$('#quantityInput'); qi.min=1; qi.max=Math.min(max,Number(b.stock)||1); qi.value=selectedQty; $('#confirmBorrow').disabled=!member;
    $('#removeBook').onclick=()=>{resetSelection();renderCatalog();renderSummary();};
  }
  function confirmBorrow(){
    const b=activeBook(); if(!member||!b||selectedQty<1)return;
    if(selectedQty>maxQty())return BinaLib.saveToast(`Maksimal ${maxQty()} eksemplar.`);
    if(Number(b.stock)<selectedQty)return BinaLib.saveToast('Stok buku tidak mencukupi.');
    const result=BinaLib.createBorrowing({studentId:Number(member.id),bookId:Number(b.id),quantity:selectedQty,loanType:loanType==='kelas'?'Kegunaan Kelas':'Penggunaan Pribadi'});
    if(!result)return;
    BinaLib.saveToast('Peminjaman berhasil dicatat.'); showStart();
  }

  function renderReturns(){
    const active=BinaLib.activeBorrowings(member.id);
    const activeIds=active.map(x=>Number(x.id));
    returnSelection=returnSelection.filter(id=>activeIds.includes(Number(id)));
    $('#returnList').innerHTML=active.length?active.map(x=>{
      const b=BinaLib.book(x.bookId); const id=Number(x.id); const checked=returnSelection.includes(id);
      const type=x.loanType==='Kegunaan Kelas'?'Kegunaan Kelas':'Penggunaan Pribadi';
      return `<label class="return-item ${checked?'selected':''}">
        <input class="return-check" type="checkbox" data-return-id="${id}" ${checked?'checked':''}>
        <div class="return-main"><div class="return-title-row"><h3>${esc(b?.title||'-')}</h3><span class="return-status">${esc(type)}</span></div>
        <p>${esc(b?.code||'')} • ${x.quantity} eksemplar • Dipinjam ${esc(BinaLib.formatDateTime(x.borrowedAt))}</p></div>
      </label>`;
    }).join(''):'<div class="empty">Tidak ada buku yang sedang dipinjam oleh siswa ini.</div>';
    $('#returnList').querySelectorAll('[data-return-id]').forEach(cb=>cb.onchange=()=>{
      const id=Number(cb.dataset.returnId);
      if(cb.checked){ if(!returnSelection.includes(id)) returnSelection.push(id); }
      else returnSelection=returnSelection.filter(x=>Number(x)!==id);
      cb.closest('.return-item')?.classList.toggle('selected',cb.checked);
      $('#confirmReturn').disabled=returnSelection.length===0;
    });
    $('#confirmReturn').disabled=returnSelection.length===0;
  }
  function confirmReturn(){
    if(!member)return;
    if(!returnSelection.length)return BinaLib.saveToast('Pilih minimal satu buku yang akan dikembalikan.');
    const result=BinaLib.returnBorrowings({studentId:Number(member.id),ids:returnSelection.map(Number)});
    if(!result)return;
    BinaLib.saveToast(`${result.count||returnSelection.length} peminjaman berhasil dikembalikan.`); showStart();
  }

  document.querySelectorAll('[data-mode]').forEach(btn=>btn.onclick=()=>chooseMode(btn.dataset.mode));
  $('#scanBtn').onclick=scan; $('#rfidInput').addEventListener('keydown',e=>{if(e.key==='Enter'){e.preventDefault();scan()}});
  $('#backBtn').onclick=showStart; $('#bookSearch').oninput=renderCatalog;
  $('#qtyMinus').onclick=()=>changeQty(-1); $('#qtyPlus').onclick=()=>changeQty(1);
  const quantityInput=$('#quantityInput');
  quantityInput.addEventListener('focus',()=>{ quantityInput.select(); });
  quantityInput.addEventListener('input',()=>{
    const b=activeBook(); if(!b)return;
    const max=Math.min(maxQty(),Number(b.stock)||1);
    const raw=quantityInput.value.trim();
    // Allow the field to be completely empty while the user is typing.
    // Do not re-render the whole summary here because that would put the
    // previous/default value back into the input before the user finishes typing.
    if(raw===''){
      selectedQty=0;
      $('#quantityLabel').textContent=`0 / ${max}`;
      $('#totalQty').textContent=`0 / ${max}`;
      $('#confirmBorrow').disabled=true;
      return;
    }
    if(!/^\d+$/.test(raw)) return;
    const value=parseInt(raw,10);
    if(!Number.isFinite(value)) return;
    selectedQty=Math.min(max,value);
    $('#quantityLabel').textContent=`${selectedQty} / ${max}`;
    $('#totalQty').textContent=`${selectedQty} / ${max}`;
    $('#confirmBorrow').disabled=!member || selectedQty<1;
  });
  quantityInput.addEventListener('blur',()=>{
    const b=activeBook(); if(!b)return;
    const max=Math.min(maxQty(),Number(b.stock)||1);
    let value=parseInt(quantityInput.value,10);
    if(!Number.isFinite(value) || value<1)value=1;
    value=Math.min(max,value);
    selectedQty=value;
    quantityInput.value=String(value);
    $('#quantityLabel').textContent=`${value} / ${max}`;
    $('#totalQty').textContent=`${value} / ${max}`;
    $('#confirmBorrow').disabled=!member;
  });
  quantityInput.addEventListener('keydown',e=>{if(['e','E','+','-','.'].includes(e.key))e.preventDefault();});
  $('#confirmBorrow').onclick=confirmBorrow; $('#confirmReturn').onclick=confirmReturn;
  document.querySelectorAll('[data-loan-type]').forEach(btn=>btn.onclick=()=>setLoanType(btn.dataset.loanType));
  function updateClock(){const d=new Date();$('#clock').textContent=d.toLocaleDateString('id-ID',{day:'2-digit',month:'short',year:'numeric'})+' • '+d.toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'});} updateClock();setInterval(updateClock,1000); applySystemSettings(); showStart();
  window.addEventListener('storage',()=>{ applySystemSettings(); if(mode==='borrow'&&member){renderCatalog();renderSummary()} if(mode==='return'&&member)renderReturns(); });
})();
