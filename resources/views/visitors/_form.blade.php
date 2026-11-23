<div class="grid2">
  <div><label for="name">Visitor name</label>
    <input id="name" name="name" value="{{ old('name', $visitor->name ?? '') }}" maxlength="100" required></div>
  <div><label for="contact_number">Contact number</label>
    <input id="contact_number" name="contact_number" value="{{ old('contact_number', $visitor->contact_number ?? '') }}" maxlength="20" inputmode="tel" required></div>
  <div><label for="person_to_visit">Person to visit</label>
    <input id="person_to_visit" name="person_to_visit" value="{{ old('person_to_visit', $visitor->person_to_visit ?? '') }}" maxlength="100"></div>
  <div><label for="department">Department</label>
    <input id="department" name="department" value="{{ old('department', $visitor->department ?? '') }}" maxlength="100"></div>
</div>
<label for="purpose">Purpose of visit</label>
<input id="purpose" name="purpose" value="{{ old('purpose', $visitor->purpose ?? '') }}" maxlength="255" required>
<p class="sub" style="margin:6px 0 0">Enter the person, the department, or both.</p>
