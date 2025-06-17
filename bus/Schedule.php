<?php
class Schedule extends Model {
    // Mencari tiket berdasarkan rute
    public function searchTickets($origin_id, $destination_id, $vehicle_type, $schedule_date) {
        $sql = "
            SELECT
                ts.*,
                o.name as operator_name,
                v.class_name as vehicle_class,
                v.type as vehicle_type,
                origin.location_name as origin_name,
                dest.location_name as destination_name
            FROM ticket_schedules ts
            JOIN transport v ON ts.vehicle_id = v.id
            JOIN operators o ON v.operator_id = o.id
            JOIN locations origin ON ts.origin_id = origin.id
            JOIN locations dest ON ts.destination_id = dest.id
            WHERE 
                ts.origin_id = ? 
                AND ts.destination_id = ? 
                AND v.type = ? 
                AND ts.schedule_date = ?  -- <-- Tambahkan kondisi filter tanggal
            ORDER BY ts.departure_time ASC
        " ;
        // Perbarui bind_param menjadi "iiss" untuk 4 parameter
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bind_param("iiss", $origin_id, $destination_id, $vehicle_type, $schedule_date);
        $stmt->execute();

        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_object()) {
            $items[] = $row;
        }
        $stmt->close();
        return $items;
    }

    public function getAll() {
        $query = "
            SELECT ts.*, v.class_name, o.name as operator_name, origin.location_name as origin, dest.location_name as destination
            FROM ticket_schedules ts
            JOIN transport v ON ts.vehicle_id = v.id
            JOIN operators o ON v.operator_id = o.id
            JOIN locations origin ON ts.origin_id = origin.id
            JOIN locations dest ON ts.destination_id = dest.id
            ORDER BY ts.schedule_date DESC, ts.departure_time ASC
        ";
        $result = $this->dbconn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Mendapatkan satu jadwal berdasarkan ID (untuk form edit)
    public function getById($id) {
        $stmt = $this->dbconn->prepare("SELECT * FROM ticket_schedules WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    // Membuat jadwal baru
    public function create($data) {
        $stmt = $this->dbconn->prepare(
            "INSERT INTO ticket_schedules (vehicle_id, origin_id, destination_id, schedule_date, departure_time, arrival_time_estimation, price, available_seats) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "iissssdi", 
            $data['vehicle_id'], 
            $data['origin_id'], 
            $data['destination_id'], 
            $data['schedule_date'], 
            $data['departure_time'],
            $data['arrival_time_estimation'],
            $data['price'],
            $data['available_seats']
        );
        return $stmt->execute();
    }

    // Memperbarui jadwal
    public function update($id, $data) {
        $stmt = $this->dbconn->prepare(
            "UPDATE ticket_schedules SET vehicle_id = ?, origin_id = ?, destination_id = ?, schedule_date = ?, departure_time = ?, arrival_time_estimation = ?, price = ?, available_seats = ? 
            WHERE id = ?"
        );
        $stmt->bind_param(
            "iiisssidi", 
            $data['vehicle_id'], 
            $data['origin_id'], 
            $data['destination_id'], 
            $data['schedule_date'], 
            $data['departure_time'],
            $data['arrival_time_estimation'],
            $data['price'],
            $data['available_seats'],
            $id
        );
        return $stmt->execute();
    }

    // Menghapus jadwal
    public function delete($id) {
        $stmt = $this->dbconn->prepare("DELETE FROM ticket_schedules WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
