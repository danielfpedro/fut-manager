<?= $this->Html->script('Game/dashboard', ['inline' => false]) ?>
<ol class="breadcrumb">
  <li><a href="#">Dashboard</a></li>
</ol>
<h2>Brasil</h2>
<div class="well">
	<div class="row">
		<div class="col-md-9">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>
							Name
						</th>
						<th>
							Pos
						</th>
						<th>Avg</th>
					</tr>
				</tbody>
				<tbody>
					<?php for ($i = 0; $i < 11; $i++): ?>
						<tr>
							<td>
								C. Ronaldo
							</td>
							<td>
								Strk.
							</td>
							<td>
								<?= $i ?>
							</td>
						</tr>
					<?php endfor ?>
				</tbody>
			</table>	
		</div>
		<div class="col-md-3">
			<select class="form-control input-sm" >
				<option>4-4-1</option>
				<option>3-5-2</option>
			</select>
			<br>
			<select class="form-control input-sm" >
				<option>Ofensiva</option>
				<option>Equilibrada</option>
				<option>Defensiva</option>
			</select>
		</div>
	</div>
</div>