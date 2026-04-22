# 🎯 Agent Selection Feature - Implementation Guide

## Overview
Sistem BERKAT sekarang memerlukan member/ahli untuk memilih agen saat membuat permohonan bantuan. Agen yang dipilih akan secara otomatis melihat permohonan dalam senarai mereka untuk semakan dan pengesahan.

## ✅ Features Implemented

### 1. Agent Selection in Request Creation
- **Mandatory Field**: Ahli WAJIB memilih agen saat membuat permohonan
- **Active Agents Only**: Hanya agen dengan status 'active' yang tersedia untuk dipilih
- **Display Format**: Agen ditampilkan dengan nama dan lokasi pejabat
  ```
  Format: [Nama Agen] - [Nama Pejabat]
  Contoh: Agen BERKAT - Pejabat BERKAT Kuala Lumpur
  ```

### 2. Agent Assignment Flow
```
Ahli membuat permohonan
    ↓
Pilih Agen (wajib)
    ↓
Simpan sebagai Draf (dengan agent_id tersimpan)
    ↓
Edit/Periksa permohonan (boleh tukar agen)
    ↓
Hantar Permohonan
    ↓
Agen melihat di senarai mereka (status: Dihantar)
    ↓
Agen mengesahkan/menolak
```

### 3. Database Changes
- `assistance_requests.agent_id` → Foreign key to `agents.id` (bukan `users.id`)
- Validation: Agen harus memiliki status 'active'

### 4. Controller Updates
**AssistanceRequestController changes:**
- Added Agent model import
- `create()`: Pass list of active agents to view
- `edit()`: Pass list of active agents to view
- `store()`: Validate agent_id is required and exists
- `update()`: Validate agent_id is required and exists
- `index()`: Fixed to show requests based on agent.id (not user.id)
  - Requests assigned to this agent
  - Requests created by this agent (their own requests)
  - Unassigned requests with submitted status
- `canViewRequest()`: Updated to check agent.id properly
  - Agent can view if assigned to request
  - Agent can view unassigned submitted requests

### 5. View Updates
**create.blade.php:**
```blade
<select class="form-select" id="agent_id" name="agent_id" required>
    <option value="">Pilih Agen</option>
    @forelse($agents as $agent)
        <option value="{{ $agent->id }}">
            {{ $agent->user->name }} - {{ $agent->office_name }}
        </option>
    @empty
        <option value="" disabled>Tiada agen aktif tersedia</option>
    @endforelse
</select>
```

**edit.blade.php:**
- Same agent selection field added
- Allows member to change agent if request still in draft

## 📋 Workflow Explanation

### For Members (Ahli)
1. **Create Request**
   - Fill form with jenis, kategori, sub-kategori
   - **Select Agent** (MANDATORY)
   - Fill applicant information
   - Click "Simpan sebagai Draf"

2. **Submit Request**
   - Open draft request
   - Verify all information and selected agent
   - Click "Hantar Permohonan"
   - Selected agent immediately sees it in their list

3. **Track Status**
   - Check "Senarai Permohonan"
   - See agent's verification notes
   - Wait for approval/rejection

### For Agents (Agen)
1. **View Assigned Requests**
   - Open "Senarai Permohonan"
   - See requests assigned to you (by agent_id)
   - See requests you created yourself
   - See unassigned requests (optional to take over)

2. **Verify Assigned Request**
   - Click request assigned to you
   - Check documents
   - Review applicant information
   - Click "Sahkan" or "Tolak"

3. **Take Over Unassigned**
   - Requests with status "Dihantar" but no agent assigned
   - Available for any agent to claim
   - Once verified, marked as handled

## 🔄 Database Relationships

```
User (Agent)
    ↓ one-to-one
Agent (Profile)
    ↓ one-to-many (as verified requests)
AssistanceRequest
```

**Foreign Keys:**
- `agents.user_id` → `users.id` (agent's user account)
- `agents.registered_by` → `users.id` (admin who registered)
- `assistance_requests.agent_id` → `agents.id` (assigned agent)

## 🧪 Test Data

Current system has:
- **2 Active Agents** available for selection
  - Agen BERKAT (Pejabat BERKAT Kuala Lumpur)
  - Agen BERKAT Kedua (Pejabat BERKAT Selangor)
- **9 Requests** assigned to agents
- **6 Requests** without agents (draft status)

## ✨ Key Benefits

1. **Direct Assignment**: No need for admin to assign agents manually
2. **Accountability**: Clear tracking of who needs to verify each request
3. **Efficiency**: Agents see their work immediately
4. **Flexibility**: Members can change agent selection if needed (while in draft)
5. **Audit Trail**: system records which agent verified each request

## 🔍 Validation Rules

### Create/Edit Request
```php
'agent_id' => 'required|exists:agents,id'
```

### Agent Selection Requirements
- Agent must exist in agents table
- Agent must have status = 'active'
- Selection is mandatory (cannot leave blank)

## 🚀 Usage Example

```php
// In Controller - Get active agents
$agents = Agent::where('status', 'active')->with('user')->get();

// In Blade View
<option value="{{ $agent->id }}">
    {{ $agent->user->name }} - {{ $agent->office_name }}
</option>

// Accessing agent from request
$request->agent; // Returns Agent model
$request->agent->user->name; // Get agent's user name
$request->agent->office_name; // Get agent's office
```

## 📝 API Changes

### Request Create/Update
Before:
```json
{
  "request_type_id": 1,
  "purpose": "...",
  ...
}
```

After (agent_id added):
```json
{
  "request_type_id": 1,
  "purpose": "...",
  "agent_id": 1,
  ...
}
```

## 🔧 Future Enhancements

1. **Agent Assignment Rules**
   - Assign based on workload distribution
   - Assign based on specialization
   - Round-robin assignment

2. **Agent Dashboard**
   - View assigned requests count
   - See pending verifications
   - Track verification statistics

3. **Automatic Assignment**
   - If member doesn't select agent, assign automatically
   - Based on availability/workload

4. **Agent Reassignment**
   - Admin can reassign requests between agents
   - If agent on leave/suspended

## 📞 Troubleshooting

### "Tiada agen aktif tersedia"
- Check if any agents have status = 'active'
- Admin must register agents with status = 'active'
- Run: `Agent::where('status', 'active')->count()`

### Agent can't see assigned requests
- Verify agent's user account has role = 'agent'
- Verify agent profile exists with correct user_id
- Check request has agent_id matching agent's id
- Verify request status is not 'draft'

### Form validation error: "agent_id invalid"
- Ensure selected agent_id exists in agents table
- Ensure agent has status = 'active'
- Verify form is submitting agent_id correctly

---

## Summary

✅ **Ahli sekarang WAJIB memilih agen saat membuat permohonan**  
✅ **Agen yang dipilih akan melihat permohonan dengan segera**  
✅ **Sistem melacak siapa yang mengesahkan setiap permohonan**  
✅ **Penuh transparency dan accountability**  

**Status: ✅ Production Ready**  
**Last Updated:** 22 April 2026  
**Version:** 1.1.0 (with agent selection)
