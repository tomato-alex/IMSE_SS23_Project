import java.sql.*;
import java.sql.Date;
import java.util.*;
import java.util.ArrayList;

public class DatabaseHelper {
    // Database connection info
    private static final String DB_CONNECTION_URL = "jdbc:mysqli://localhost:3306/imse_23_ss";
    private static final String USER = "root";
    private static final String PASS = "testpass";

    // Connection and Statement needed for the execution
    private static Connection con;
    private static Statement stmt;
    private static PreparedStatement prepStmt;

    DatabaseHelper() {
        try {
            // Establish a connection to the database
            con = DriverManager.getConnection(DB_CONNECTION_URL, USER, PASS);
            stmt = con.createStatement();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    // INSERT INTO
    public void insertIntoFiliale(String stadt, String land, String adresse) {
        String statementString = "INSERT INTO location(city, country, address) VALUES (?,?,?)";
        try {
            prepStmt = con.prepareStatement(statementString);
            prepStmt.setString(1, stadt);
            prepStmt.setString(2, land);
            prepStmt.setString(3, adresse);
            prepStmt.executeUpdate();
            prepStmt.close();
        } catch (Exception e) {
            System.err.println("Error at: insertIntoFiliale\nmessage: " + e.getMessage());
        }
    }

    public void insertIntoAutowerkstatt(int fid, String telefonnummer, int Anz_mit) {
        String statementString = "INSERT INTO workshop(locationId, phone_number, employee_count) VALUES (?,?,?)";
        try {
            prepStmt = con.prepareStatement(statementString);
            prepStmt.setInt(1, fid);
            prepStmt.setString(2, telefonnummer);
            prepStmt.setInt(3, Anz_mit);
            prepStmt.executeUpdate();
            prepStmt.close();
        } catch (Exception e) {
            System.err.println("Error at: insertIntoAutowerkstatt\nmessage: " + e.getMessage());
        }
    }

    public void insertIntoLeasing(int dauer, double preis) {
        String statementString = "INSERT INTO leasing(duration, fee) VALUES (?,?)";
        try {
            prepStmt = con.prepareStatement(statementString);
            prepStmt.setInt(1, dauer);
            prepStmt.setDouble(2, preis);
            prepStmt.executeUpdate();
            prepStmt.close();
        } catch (Exception e) {
            System.err.println("Error at: insertIntoLeasing\nmessage: " + e.getMessage());
        }
    }

    public void insertIntoAuto(String marke, String modell, int lnr) {
        String statementString = "INSERT INTO car(brand, modell, leasingNr) VALUES (?,?,?)";
        try {
            prepStmt = con.prepareStatement(statementString);
            prepStmt.setString(1, marke);
            prepStmt.setString(2, modell);
            prepStmt.setInt(3, lnr);
            prepStmt.executeUpdate();
            prepStmt.close();
        } catch (Exception e) {
            System.err.println("Error at: insertIntoAuto\nmessage: " + e.getMessage());
        }
    }

    public void insertIntoMitarbeiter(String vorname, String nachname, int fid, Integer chefid) {
        if (chefid == null) {
            String statementString = "INSERT INTO employee(first_name, last_name, locationId) VALUES (?,?,?)";
            try {
                prepStmt = con.prepareStatement(statementString);
                prepStmt.setString(1, vorname);
                prepStmt.setString(2, nachname);
                prepStmt.setInt(3, fid);
                prepStmt.executeUpdate();
                prepStmt.close();

            } catch (Exception e) {
                System.err.println("Error at: insertIntoMitarbeiter\nmessage: " + e.getMessage());
            }
        } else {
            String statementString = "INSERT INTO employee(first_name, last_name, locationId, managerId) VALUES (?,?,?,?)";
            try {
                prepStmt = con.prepareStatement(statementString);
                prepStmt.setString(1, vorname);
                prepStmt.setString(2, nachname);
                prepStmt.setInt(3, fid);
                prepStmt.setInt(4, chefid);
                prepStmt.executeUpdate();
                prepStmt.close();
            } catch (Exception e) {
                System.err.println("Error at: insertIntoMitarbeiter\nmessage: " + e.getMessage());
            }
        }
    }

    public void insertIntoVerkauft(int mid, int aid, double preis, String date) {
        String statementString = "INSERT INTO sells(employeeId, carId, price, date) VALUES (?,?,?,?)";
        try {
            prepStmt = con.prepareStatement(statementString);
            prepStmt.setInt(1, mid);
            prepStmt.setInt(2, aid);
            prepStmt.setDouble(3, preis);
            prepStmt.setDate(4, Date.valueOf(date));
            prepStmt.executeUpdate();
            prepStmt.close();
        } catch (Exception e) {
            System.err.println("Error at: insertIntoVerkauft\nmessage: " + e.getMessage());
        }
    }

    public void insertIntoHat(int fid, int aid) {
        String statementString = "INSERT INTO has(locationId, carId) VALUES (?,?)";
        try {
            prepStmt = con.prepareStatement(statementString);
            prepStmt.setInt(1, fid);
            prepStmt.setInt(2, aid);
            prepStmt.executeUpdate();
            prepStmt.close();
        } catch (Exception e) {
            System.err.println("Error at: insertIntoHat\nmessage: " + e.getMessage());
        }
    }

    // SELECT autogenerated ids

    // get filial ids
    public List<Integer> getFid() {
        List<Integer> fid = new ArrayList<>();
        ResultSet rs;
        try {
            rs = stmt.executeQuery("SELECT locationId FROM location");
            while (rs.next()) {
                fid.add(rs.getInt(1));
            }
            rs.close();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return fid;
    }

    // get leasingNr
    public List<Integer> getLeasingNR() {
        List<Integer> lnr = new ArrayList<>();
        ResultSet rs;
        try {
            rs = stmt.executeQuery("SELECT leasingNr FROM leasing");
            while (rs.next()) {
                lnr.add(rs.getInt(1));
            }
            rs.close();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return lnr;
    }

    // get autoId
    public List<Integer> getAutoId() {
        List<Integer> aid = new ArrayList<>();
        ResultSet rs;
        try {
            rs = stmt.executeQuery("SELECT carId FROM car");
            while (rs.next()) {
                aid.add(rs.getInt(1));
            }
            rs.close();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return aid;
    }

    // get MitarbeiterId
    public List<Integer> getMitarbeiterId() {
        List<Integer> mid = new ArrayList<>();
        ResultSet rs;
        try {
            rs = stmt.executeQuery("SELECT employeeId FROM employee");
            while (rs.next()) {
                mid.add(rs.getInt(1));
            }
            rs.close();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return mid;
    }

    public Map<Integer, Integer> getFidMid() {
        Map<Integer, Integer> fidAndMid = new HashMap<>();
        ResultSet rs;
        try {
            rs = stmt.executeQuery("SELECT locationId, managerId FROM employee");
            while (rs.next()) {
                fidAndMid.put(rs.getInt(1), rs.getInt(2));
            }
            rs.close();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return fidAndMid;
    }

    // Clean up connection
    public void close() {
        try {
            stmt.close();
            con.close();
        } catch (Exception e) {
            System.err.println(e.toString());
        }
    }
}