import java.util.*;

public class Main {
    public static void main(String[] args) {
        DatabaseHelper helper = new DatabaseHelper();
        DataGenerator dgen = new DataGenerator();
        Random rand = new Random();


        //Location insertion
        for (int i = 0; i < 100; ++i) {
            int getter = rand.nextInt(dgen.getCitiesAndCountriesSize());
            helper.insertIntoLocation(dgen.getCity(getter), dgen.getCountry(getter), dgen.getRandomAddress());
        }

        //Workshop insertion
        List<Integer> locationId = helper.getLocationId();
        for (int i = 0; i < 150; ++i) {
            int workerCount = rand.nextInt(6) + 1;
            long j = 6679220592L + i;
            String telefonnummer = "+43" + j;
            int random = rand.nextInt(locationId.size());
            helper.insertIntoWorkshop(locationId.get(random), telefonnummer, workerCount);
        }

        //Leasing insertion
        for (int i = 0; i < 25; ++i) {
            int dauer = rand.nextInt(10) + 1;
            double cents = rand.nextInt(100) / 100.00;
            double preis = rand.nextInt(200000 - 30000) + 30000 + cents;
            helper.insertIntoLeasing(dauer, preis);
        }

        //Car insertion
        List<Integer> lnr = helper.getLeasingNR();
        for (int i = 0; i <= 300; ++i) {
            int random = rand.nextInt(lnr.size());
            int getter = rand.nextInt(dgen.getCarsSize());
            helper.insertIntoCar(dgen.getBrand(getter), dgen.getModel(getter), lnr.get(random));
        }

        List<Integer> carIds = helper.getCarId();

        //Employee insertion
        for (int i = 0; i < locationId.size(); ++i) { // workers without bosses
            int randomName = rand.nextInt(dgen.getFirstNameSize());
            int randomSurname = rand.nextInt(dgen.getSurnameSize());
            helper.insertIntoEmployee(dgen.getFirstName(randomName), dgen.getSurname(randomSurname), locationId.get(i), null); // in every location/filiale will be one boss
        }


        {
            Map<Integer, Integer> filialAndMitarbeiter = helper.getLocationIdAndEmployeeId();
            for (int i = 0; i < locationId.size(); ++i) {
                for (int j = 0; j < 5; ++j) {
                    int randomName = rand.nextInt(dgen.getFirstNameSize());
                    int randomSurname = rand.nextInt(dgen.getSurnameSize());
                    helper.insertIntoEmployee(dgen.getFirstName(randomName), dgen.getSurname(randomSurname), locationId.get(i), filialAndMitarbeiter.get(i));
                }
            }
        }

        //has insert
        Set<Integer> numbers = new HashSet<>();
        for (int i = 0; i < helper.getLocationId().size(); ++i) {
            numbers.clear();
            for (int j = 0; j <= 30; ++j) {
                int random = rand.nextInt(carIds.size());
                while (numbers.contains(random)) {
                    random = rand.nextInt(carIds.size());
                }
                numbers.add(random);
                helper.insertIntoHas(locationId.get(i), carIds.get(random));
            }
        }


        //Sells insert
        List<Integer> employeeIds = helper.getEmployeeId();
        Set<Integer> usedNumbers = new HashSet<>();

        for (int i = 0; i < 200; ++i) {
            Double preis = (rand.nextInt(200000 - 20000) + 20000) * 100 / 100.00;
            int randomMitarbeiter = rand.nextInt(employeeIds.size());
            int randomAuto = rand.nextInt(carIds.size());
            while (usedNumbers.contains(randomAuto)) {
                randomAuto = rand.nextInt(carIds.size());
            }
            usedNumbers.add(randomAuto);
            String date = (rand.nextInt(2022 - 2012) + 2012) + "-" + (rand.nextInt(12) + 1) + "-" + (rand.nextInt(28) + 1);
            helper.insertIntoSells(employeeIds.get(randomMitarbeiter), carIds.get(randomAuto), preis, date);
        }

    }
}
