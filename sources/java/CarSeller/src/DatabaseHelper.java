import java.sql.*;
import java.sql.Date;
import java.util.*;
import java.util.ArrayList;

public class DatabaseHelper {
    private static final String JDBC_DRIVER = "com.mysql.cj.jdbc.Driver";
    private static final String DB_CONNECTION_URL = "jdbc:mysql://localhost:3306/imse_23_ss";
    private static final String USER = "root";
    private static final String PASS = "testpass";

    // Connection and Statement needed for the execution
    private static Connection con;
    private static Statement stmt;
    private static PreparedStatement prepStmt;

    DatabaseHelper() {
        try {
            Class.forName(JDBC_DRIVER);
            // Establish a connection to the database
            con = DriverManager.getConnection(DB_CONNECTION_URL, USER, PASS);
            stmt = con.createStatement();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    // INSERT INTO
    public void insertIntoLocation(String city, String country, String address) {
        String statementString = "INSERT INTO location(city, country, address) VALUES (?,?,?)";
        try {
            prepStmt = con.prepareStatement(statementString);
            prepStmt.setString(1, city);
            prepStmt.setString(2, country);
            prepStmt.setString(3, address);
            prepStmt.executeUpdate();
            prepStmt.close();
        } catch (Exception e) {
            System.err.println("Error at: insertIntoLocation\nmessage: " + e.getMessage());
        }
    }

    public void insertIntoWorkshop(int locationId, String phoneNumber, int employeeCount) {
        String statementString = "INSERT INTO WORKSHOP(locationId, phone_number, employee_count) VALUES (?,?,?)";
        try {
            prepStmt = con.prepareStatement(statementString);
            prepStmt.setInt(1, locationId);
            prepStmt.setString(2, phoneNumber);
            prepStmt.setInt(3, employeeCount);
            prepStmt.executeUpdate();
            prepStmt.close();
        } catch (Exception e) {
            System.err.println("Error at: insertIntoWorkshop\nmessage: " + e.getMessage());
        }
    }

    public void insertIntoLeasing(int duration, double fee) {
        String statementString = "INSERT INTO LEASING(duration, fee) VALUES (?,?)";
        try {
            prepStmt = con.prepareStatement(statementString);
            prepStmt.setInt(1, duration);
            prepStmt.setDouble(2, fee);
            prepStmt.executeUpdate();
            prepStmt.close();
        } catch (Exception e) {
            System.err.println("Error at: insertIntoLeasing\nmessage: " + e.getMessage());
        }
    }

    public void insertIntoCar(String brand, String model, int leasingNr) {
        String statementString = "INSERT INTO CAR(brand, model, leasingNr) VALUES (?,?,?)";
        try {
            prepStmt = con.prepareStatement(statementString);
            prepStmt.setString(1, brand);
            prepStmt.setString(2, model);
            prepStmt.setInt(3, leasingNr);
            prepStmt.executeUpdate();
            prepStmt.close();
        } catch (Exception e) {
            System.err.println("Error at: insertIntoCar\nmessage: " + e.getMessage());
        }
    }

    public void insertIntoEmployee(String firstName, String lastName, int locationId, Integer managerId) {
        if (managerId == null) {
            String statementString = "INSERT INTO EMPLOYEE(first_name, last_name, locationId) VALUES (?,?,?)";
            try {
                prepStmt = con.prepareStatement(statementString);
                prepStmt.setString(1, firstName);
                prepStmt.setString(2, lastName);
                prepStmt.setInt(3, locationId);
                prepStmt.executeUpdate();
                prepStmt.close();

            } catch (Exception e) {
                System.err.println("Error at: insertIntoEmployee\nmessage: " + e.getMessage());
            }
        } else {
            String statementString = "INSERT INTO EMPLOYEE(first_name, last_name, locationId, managerId) VALUES (?,?,?,?)";
            try {
                prepStmt = con.prepareStatement(statementString);
                prepStmt.setString(1, firstName);
                prepStmt.setString(2, lastName);
                prepStmt.setInt(3, locationId);
                prepStmt.setInt(4, managerId);
                prepStmt.executeUpdate();
                prepStmt.close();
            } catch (Exception e) {
                System.err.println("Error at: insertIntoEmployee with manager\nmessage: " + e.getMessage());
            }
        }
    }

    public void insertIntoSells(int employeeId, int carId, double price, String date) {
        String statementString = "INSERT INTO VERKAUFT(employeeId, carId, price, date) VALUES (?,?,?,?)";
        try {
            prepStmt = con.prepareStatement(statementString);
            prepStmt.setInt(1, employeeId);
            prepStmt.setInt(2, carId);
            prepStmt.setDouble(3, price);
            prepStmt.setDate(4, Date.valueOf(date));
            prepStmt.executeUpdate();
            prepStmt.close();
        } catch (Exception e) {
            System.err.println("Error at: insertIntoSells\nmessage: " + e.getMessage());
        }
    }

    public void insertIntoHas(int locationId, int carId) {
        String statementString = "INSERT INTO HAS(locationId, carId) VALUES (?,?)";
        try {
            prepStmt = con.prepareStatement(statementString);
            prepStmt.setInt(1, locationId);
            prepStmt.setInt(2, carId);
            prepStmt.executeUpdate();
            prepStmt.close();
        } catch (Exception e) {
            System.err.println("Error at: insertIntoHas\nmessage: " + e.getMessage());
        }
    }

    // SELECT autogenerated ids

    // SELECT autogenerated ids

    // get filial ids
    public List<Integer> getLocationId() {
        List<Integer> id = new ArrayList<>();
        ResultSet rs;
        try {
            rs = stmt.executeQuery("SELECT locationId FROM location");
            while (rs.next()) {
                id.add(rs.getInt(1));
            }
            rs.close();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return id;
    }

    // get leasingNr
    public List<Integer> getLeasingNR() {
        List<Integer> lnr = new ArrayList<>();
        ResultSet rs;
        try {
            rs = stmt.executeQuery("SELECT leasingNr FROM LEASING");
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
    public List<Integer> getCarId() {
        List<Integer> ids = new ArrayList<>();
        ResultSet rs;
        try {
            rs = stmt.executeQuery("SELECT carId FROM car");
            while (rs.next()) {
                ids.add(rs.getInt(1));
            }
            rs.close();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return ids;
    }

    // get MitarbeiterId
    public List<Integer> getEmployeeId() {
        List<Integer> employeeIds = new ArrayList<>();
        ResultSet rs;
        try {
            rs = stmt.executeQuery("SELECT employeeId FROM employee");
            while (rs.next()) {
                employeeIds.add(rs.getInt(1));
            }
            rs.close();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return employeeIds;
    }

    public Map<Integer, Integer> getLocationIdAndEmployeeId() {
        Map<Integer, Integer> locationIdandEmployeeIds = new HashMap<>();
        ResultSet rs;
        try {
            rs = stmt.executeQuery("SELECT locationId, employeeId FROM employee");
            while (rs.next()) {
                locationIdandEmployeeIds.put(rs.getInt(1), rs.getInt(2));
            }
            rs.close();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return locationIdandEmployeeIds;
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