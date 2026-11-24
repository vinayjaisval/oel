(() => {
  const root = document.getElementById('oel-admin-dashboard');
  const source = document.getElementById('oel-legacy-metrics');
  if (!root || !source) return;
  const kpis = document.getElementById('oel-dashboard-kpis');
  const attention = document.getElementById('oel-attention-items');
  const groups = {leads: document.getElementById('oel-group-leads'), members: document.getElementById('oel-group-members'), programs: document.getElementById('oel-group-programs')};
  const kpiOrder = {'Total Leads': 0, 'Total Students': 1, 'Total Programs': 3};
  const attentionNames = {'Total Non Allocated Leads': ['Unallocated Leads', 0], 'Visa Pending': ['Pending Visa Cases', 2], 'Total UnApprove Universities': ['Universities Awaiting Approval', 3]};
  const actionNames = {'Total Leads':'View Leads','Total Students':'View Students','Total Programs':'View Programs','Total Non Allocated Leads':'View Leads','Total UnApprove Universities':'Review Universities','Visa Pending':'View Students','Total Allocated Leads':'View Allocated Leads','Total Applied Program':'View Applications','Total Members':'View Members','Total Franchise':'View Franchises','Total Sub Agents':'View Sub Agents'};
  const icons = {'Total Leads':'la-users','Total Students':'la-graduation-cap','Total Programs':'la-cubes','Total Non Allocated Leads':'la-user-plus','Visa Pending':'la-globe','Total UnApprove Universities':'la-university'};
  function icon(name) { const box=document.createElement('span');box.className='oel-kpi-icon';const i=document.createElement('i');i.className='la '+(icons[name] || 'la-file-text-o');i.setAttribute('aria-hidden','true');box.appendChild(i);return box; }
  function action(link, name) { if (!link || !link.getAttribute('href') || link.getAttribute('href') === '#') return null; const a=document.createElement('a');a.className='oel-action';a.href=link.href;a.textContent=(actionNames[name] || 'View details')+' →';return a; }
  function textValue(card) { const node=card.querySelector('.blclr h5');if(!node)return '';const copy=node.cloneNode(true);copy.querySelectorAll('i,svg').forEach(x=>x.remove());return copy.textContent.trim().replace(/\s+/g,' '); }
  Array.from(source.querySelectorAll('.dash-widget')).forEach(card => {
    const original=card.parentElement, title=card.querySelector('.totalno h5');if(!original||!title)return;
    const name=title.textContent.trim().replace(/\s+/g,' '), value=textValue(card), link=card.querySelector('.submit-section a');
    if(Object.prototype.hasOwnProperty.call(kpiOrder,name)) {
      const item=document.createElement('article');item.className='oel-kpi';item.dataset.kpiOrder=kpiOrder[name];item.appendChild(icon(name));const content=document.createElement('div');content.className='oel-kpi-content';const h=document.createElement('h2');h.textContent=name;const count=document.createElement('strong');count.textContent=value;content.append(h,count);const a=action(link,name);if(a)content.appendChild(a);item.appendChild(content);kpis.appendChild(item);
    } else if(Object.prototype.hasOwnProperty.call(attentionNames,name)) {
      const item=document.createElement('div');item.className='oel-attention-row';item.dataset.attentionOrder=attentionNames[name][1];const heading=document.createElement('div');heading.className='oel-attention-label';heading.appendChild(icon(name));const label=document.createElement('span');label.textContent=attentionNames[name][0];heading.appendChild(label);const count=document.createElement('strong');count.textContent=value;item.append(heading,count);const a=action(link,name);if(a)item.appendChild(a);attention.appendChild(item);
    } else {
      const lower=name.toLowerCase();const group=/university|universit|program added|total program|programs/.test(lower)&&!/applied program/.test(lower)?groups.programs:/member|franchise|agent|counsel/.test(lower)?groups.members:groups.leads;
      const row=document.createElement('div');row.className='oel-group-row';const label=action(link,name);if(label){label.className='oel-row-label';label.textContent=name;}else{const span=document.createElement('span');span.textContent=name;row.appendChild(span);}if(label)row.appendChild(label);const count=document.createElement('strong');count.textContent=value;row.appendChild(count);group.appendChild(row);
    }
    original.remove();
  });
  Array.from(kpis.children).sort((a,b)=>Number(a.dataset.kpiOrder)-Number(b.dataset.kpiOrder)).forEach(item=>kpis.appendChild(item));
  Array.from(attention.children).sort((a,b)=>Number(a.dataset.attentionOrder)-Number(b.dataset.attentionOrder)).forEach(item=>attention.appendChild(item));
  if(!attention.children.length)document.getElementById('oel-attention').hidden=true;
  Object.values(groups).forEach(group=>{if(!group.children.length)group.closest('section').hidden=true;});
})();
