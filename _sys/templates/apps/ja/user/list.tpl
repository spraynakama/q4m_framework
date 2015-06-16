<table class="table table-condensed table-striped table-hover">
    
  <colgroup>
    <col width="15%">
    <col width="20%">
    <col width="20%">
    <col width="15%">
    <col width="10%">
    <col width="20%">
  </colgroup>
  <thead>
      <tr>
          <th>{#pref#}</th>
          <th>{#shop#}</th>
          <th>{#name#}</th>
          <th style="text-align: center;">{#staff_code#}</th>
          <th style="text-align: center;">{#on_off#}</th>
          <th style="text-align: center;">{#last_login#}</th>
      </tr>
  </thead>
  <tbody>
      {foreach from=$staffs item=datum}
          <tr class="user_row" data-id="{$datum.id}">
              <td>{$datum.pref}</td>
              <td>{$datum.shop}</td>
              <td>{$datum.name}</td>
              <td style="text-align: right;">{$datum.staff_code}</td>
              <td style="text-align: center;"><span class="glyphicon{if $datum.on_off} glyphicon-ok-circle{else}glyphicon-ban-circle{/if}"></span></td>
              <td style="text-align: center;">{$datum.last_login}</td>
          </tr>    
      {/foreach}
  </tbody>
</table>