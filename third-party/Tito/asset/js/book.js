/**
 * @param {Array<Car>}  carsList            The cars list to print
 * @param {string}      containerSelector   The container selector where print the cars list
 * @param {object}      opts                The build options
 */
function initCarsList(carsList, containerSelector, opts) {

    // Throw error if no car in list
    if (!Array.isArray(carsList)) {
        throw new Error('Missing carsList parameter or is not an array');
    }

    // Throw error if no container selector
    if (!containerSelector) {
        throw new Error('Missing containerSelector parameter');
    }

    opts = opts || {};

    // Get container reference
    const container = $(containerSelector);
    // Create table
    const table = $('<table class="' + (opts.tableClass || '') + '"></table>');
    // Create body table
    const tableBody = $('<tbody></tbody>');

    // Append row for each car into cars list
    carsList.forEach((car, index) => tableBody.append(buildCardRow(car, {
        buttonClass: opts.buttonClass,
        buttonContent: opts.buttonContent || 'Book it',
        buttonClick: opts.buttonClick || function(id, index, elm) {},
        idKey: opts.idKey ||  'id',
        index
    })));

    // If no car into cars list, then append empty row
    if (!carsList.length) {
        tableBody.append(buildEmptyListRow(opts.emptyListMessage || 'No Cars', opts.emptyListClass));
    }

    // Append body table into table
    table.append(tableBody);
    // Replace container content by the created table
    container.html(table);
}

/**
 * @param {string} emptyListMessage The empty list message
 * @param {string} emptyListClass   The empty list "td" class
 * @return
 */
function buildEmptyListRow(emptyListMessage, emptyListClass) {
    return $(`<tr colSpan="4">
        <td class="${emptyListClass || ''}">${emptyListMessage}</td>
    </tr>`);
}

/**
 * @param {Car} data    The car to display
 * @param {object} opts The build options
 * @return
 */
function buildCardRow(data, opts) {

    opts = opts || {};

    const row = $(`<tr>
        <td><img src="${data.picture}"/></td>
        <td>${data.name}</td>
        <td>${data.capa}% capa remaining</td>
        <td>${data.location} km away</td>
    </tr>`);

    if (data.available) {
        // Create avaible td
        const tdAvailable = $('<td>available</td>');
        const tdButton = $('<td class="text-right"></td>');
        // Create book button
        const button = $('<button data-index="' + opts.index + '" class="' + (opts.buttonClass || '') + '" type="button">' + opts.buttonContent + ' </button>');

        // Attach click event
        button.click(function(elm) {
            // Call button click function
            opts.buttonClick(data[opts.idKey], opts.index, elm);
        });

        tdButton.append(button);
        row.append(tdAvailable);
        row.append(tdButton);
    } else {
        row.append('<td>not available</td>');
        row.append('<td></td>');

    }
    return row;
}